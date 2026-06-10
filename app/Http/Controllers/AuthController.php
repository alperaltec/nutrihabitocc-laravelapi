<?php

namespace App\Http\Controllers;

use App\Mail\RegisterMail;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use App\Models\UserDevice;
use App\Traits\ApiResponse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    use ApiResponse;
    /**
     * Registro de nuevo usuario.
     *
     * Este endpoint es público y permite crear una cuenta.
     * @unauthenticated
     */
    public function registro(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
            'password' => Hash::make($data['password']),
            'is_active' => true,
        ]);

        $role = DB::table('roles')->where('name', 'Paciente')->first();

        if (!$role) {
            return response()->json('El rol Paciente no existe en el sistema.', 404);
        }

        DB::table('user_roles')->insert([
            'user_id' => $user->id,
            'role_id' => $role->id,
            'created_at' => Carbon::now(),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;
        Mail::to($user->email)->send(new RegisterMail($user));
        return $this->successResponse(
            [
                'access_token' => $token,
                'user' => $user,
                'role'         => [
                    'id'   => $role->id,
                    'name' => $role->name
                ]
            ], 'Registro exitoso', 201
        );
    }

    /**
     * Inicio de sesion.
     *
     * Este endpoint es público y permite ingresar a la app.
     * @unauthenticated
     */
    public function login(Request $request){
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if(!$user || !Hash::check($data['password'], $user->password)){
            return $this->errorResponse('Las credenciales no coinciden', 401);
        }
        $roleInfo = DB::table('user_roles')
            ->join('roles', 'user_roles.role_id', '=', 'roles.id')
            ->where('user_roles.user_id', $user->id)
            ->select('roles.id', 'roles.name')
            ->first();

        $token = $user->createToken('auth_token')->plainTextToken;
        return $this->successResponse([
            'access_token' => $token,
            'user' => $user,
            'role' => $roleInfo ? [
                'id'   => $roleInfo->id,
                'name' => $roleInfo->name
            ] : null
        ], 'Ingreso exitoso', 201);
    }

    /**
     * Enviar correo de Recuperacion.
     *
     * Este endpoint es público y permite enviar un codigo al correo registrado para recuperar la contrasena.
     * @unauthenticated
     */
    public function sendCode(Request $request){
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);

        $user = User::where('email', $data['email'])->first();
        if(!$user){
            return $this->successResponse([],'Se enviará el código de recuperación al correo correspondiente', 200);
        }
        $code = str_pad(rand(0,999999),6, '0', STR_PAD_LEFT);
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $user->email],
            [
                'token' => HasH::make($code),
                'created_at' => now()
            ]
        );
        Mail::to($user->email)->send(new ResetPasswordMail($user, $code));
        return $this->successResponse([],'Se enviará el código de recuperación al correo correspondiente',200 );
    }

    /**
     * Validar Credenciales de Recuperacion.
     *
     * Este endpoint es público y permite validar el correo, codigo y contrasena para recuperar la contrasena.
     * @unauthenticated
     */
    public function resetPassword(Request $request){
        $data = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'code' => ['required'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        $user = User::where('email', $data['email'])->first();
        if(!$user){
            return $this->errorResponse('Usuario no encontrado', 401);
        }
        $code = DB::table('password_reset_tokens')->where('email', $data['email'])->first();
        if(!$code){
            return $this->errorResponse('Codigo invalido', 401);
        }
        if(!Hash::check($data['code'], $code->token)){
            return $this->errorResponse('Codigo invalido', 401);
        }
        if(Carbon::parse($code->created_at)->addMinutes(5)->isPast()){
            DB::table('password_reset_tokens')->where('email', $data['email'])->delete();
            return $this->errorResponse('El código ha expirado', 401);
        }

        $user->update([
            'password' => Hash::make($data['password']),
        ]);

        DB::table('password_reset_tokens')->where('email', $data['email'])->delete();
        return $this->successResponse([],'Contraseña actualizada con éxito', 200);
    }

    public function logout(Request $request){
        $data = $request->validate([
            'device_token' => ['required', 'string'],
        ]);
        UserDevice::where('device_token', $data['device_token'])
            ->where('user_id', $request->user()->id)
            ->delete();
        return $this->successResponse([],'Dispositivo desvinculado con éxito',200);
    }
}

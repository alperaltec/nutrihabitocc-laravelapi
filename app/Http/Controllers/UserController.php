<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDevice;
use App\Models\Workspace;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    use ApiResponse;

    public function savedevice(Request $request)
    {
        $data = $request->validate([
            'device_token' => 'required|string',
            'device_type' => 'required|string',
            'device_os' => 'required|string',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        UserDevice::updateOrCreate(
            ['device_token' => $data['device_token']],
            [
                'device_type' => $data['device_type'],
                'device_os' => $data['device_os'],
                'user_id' => $data['user_id']
            ]
        );
        return $this->successResponse([], 'Dispositivo registrado', 201);
    }

    public function actualizarDatosPersonales(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $request->user_id],
            'phone_number' => ['nullable', 'string', 'max:20'],
        ]);

        $usuario = User::findOrFail($data['user_id']);
        $usuario->update([
            'name' => $data['name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone_number' => $data['phone_number'],
        ]);

        return $this->successResponse($usuario, 'Datos personales actualizados con éxito', 200);
    }

    public function crearactualizarperfil(Request $request)
    {
        $data = $request->validate([
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'birth_date' => 'required|date',
            'gender' => 'required|string',
            'grasa_corporal' => 'required|numeric',
            'masa_muscular' => 'required|numeric',
            'user_id' => 'required|integer|exists:users,id'
        ]);

        Profile::updateOrCreate(
            ['user_id' => $data['user_id']],
            [
                'height' => $data['height'],
                'weight' => $data['weight'],
                'birth_date' => $data['birth_date'],
                'gender' => $data['gender'],
                'grasa_corporal' => $data['grasa_corporal'],
                'masa_muscular' => $data['masa_muscular'],
            ]
        );
        return $this->successResponse([], 'Perfil Procesado Correctamente', 200);
    }

    public function obtenerPerfil(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
        ]);

        $perfil = Profile::where('user_id', $data['user_id'])->first();
        if (!$perfil) {
            return $this->successResponse([
                'perfil' => null
            ], 'El usuario existe, pero aún no tiene un perfil creado', 200);
        }

        return $this->successResponse([
            'perfil' => $perfil
        ], 'Perfil obtenido con éxito', 200);
    }

    public function rolesall()
    {
        $roles = Role::where('is_active', true)->get(['id', 'name']);
        return $this->successResponse([
            'roles' => $roles
        ], 'Roles registrados', 200);
    }

    public function asignaroactualizarrol(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'role_id' => 'required|integer|exists:roles,id'
        ]);

        DB::table('user_roles')->updateOrInsert(
            ['user_id' => $data['user_id']],
            [
                'user_id' => $data['user_id'],
                'role_id' => $data['role_id'],
                'updated_at' => now(),
                'created_at' => now()
            ]
        );

        return $this->successResponse([], 'Rol Asignado', 200);
    }

    public function modificarestadoUsuario(Request $request)
    {
        $data = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);
        $usuario = User::findOrFail($data['user_id']);
        $usuario->update([
            'is_active' => !$usuario->is_active,
        ]);
        $estadoTexto = $usuario->is_active ? 'activado' : 'desactivado';
        return $this->successResponse([], "Usuario {$estadoTexto} Actualizado", 200);
    }

    public function actualizarpasswordUsuario(Request $request)
    {
        $data = $request->validate([
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'password' => ['required', 'string', 'min:6'],
        ]);

        $usuario = User::findOrFail($data['user_id']);
        $usuario->update([
            'password' => bcrypt($data['password']),
        ]);

        return $this->successResponse([], 'Contraseña de usuario actualizada con éxito', 200);
    }

    public function listadoUsuarios(Request $request)
    {
        $data = $request->validate([
            'filtro_usuario' => ['nullable', 'boolean'],
            'filtro_nutricionista' => ['nullable', 'boolean'],
            'filtro_inactivos' => ['nullable', 'boolean'],
            'buscar_nombre' => ['nullable', 'string', 'max:255'],
        ]);

        $filtroUsuario = $data['filtro_usuario'] ?? false;
        $filtroNutricionista = $data['filtro_nutricionista'] ?? false;
        $filtroInactivos = $data['filtro_inactivos'] ?? false;
        $buscarNombre = $data['buscar_nombre'] ?? null;

        $userAutenticado = $request->user();

        $query = User::with('roles:id,name');
        if ($userAutenticado->roles()->where('name', 'Nutricionista')->exists()) {
            $workspacesIds = $userAutenticado->workspaces()->pluck('workspaces.id');

            $query->whereHas('workspaces', function ($q) use ($workspacesIds) {
                $q->whereIn('workspaces.id', $workspacesIds);
            });
            $query->whereHas('roles', function ($q) {
                $q->where('name', 'Paciente');
            });
        }

        if ($filtroInactivos) {
            $query->where('is_active', false);
        } else {
            $query->where('is_active', true);
        }

        if (!$userAutenticado->roles()->where('name', 'Nutricionista')->exists()) {
            if ($filtroUsuario) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'Paciente');
                });
            }

            if ($filtroNutricionista) {
                $query->whereHas('roles', function ($q) {
                    $q->where('name', 'Nutricionista');
                });
            }
        }

        if ($buscarNombre) {
            $query->where(function ($q) use ($buscarNombre) {
                $q->where('name', 'LIKE', '%' . $buscarNombre . '%')
                    ->orWhere('last_name', 'LIKE', '%' . $buscarNombre . '%');
            });
        }

        $usuarios = $query->get();
        return $this->successResponse($usuarios, 'Listado de usuarios obtenido con éxito', 200);
    }

    public function listadoUsuariosPacientes()
    {
        $query = User::with('roles:id,name');
        $query->whereHas('roles', function ($q) {
            $q->where('name', 'Paciente');
        });

        $usuarios = $query->get();
        return $this->successResponse($usuarios, 'Listado de usuarios obtenido con éxito', 200);
    }

    public function listadoUsuariosNutricionistas()
    {
        $query = User::with('roles:id,name');
        $query->whereHas('roles', function ($q) {
            $q->where('name', 'Nutricionista');
        });

        $usuarios = $query->get();
        return $this->successResponse($usuarios, 'Listado de usuarios obtenido con éxito', 200);
    }

    public function kpis(Request $request)
    {
        $user = $request->user();

        if ($user->roles()->where('name', 'Nutricionista')->exists()) {

            $workspacesIds = $user->workspaces()->pluck('workspaces.id');

            $totalWorkspaces = Workspace::whereIn('id', $workspacesIds)
                ->where('is_active', true)
                ->count();

            $totalPacientes = User::whereHas('roles', function ($q) {
                $q->where('name', 'Paciente');
            })
                ->whereHas('workspaces', function ($q) use ($workspacesIds) {
                    $q->whereIn('workspaces.id', $workspacesIds);
                })
                ->where('is_active', true)
                ->count();

            $totalUsuariosActivos = $totalPacientes;
            $totalNutricionistas = 1;

        } else {
            $totalUsuariosActivos = User::where('is_active', true)->count();

            $totalPacientes = User::whereHas('roles', function ($q) {
                $q->where('name', 'Paciente');
            })->count();

            $totalNutricionistas = User::whereHas('roles', function ($q) {
                $q->where('name', 'Nutricionista');
            })->count();

            $totalWorkspaces = Workspace::where('is_active', true)->count();
        }

        return $this->successResponse([
            'total_usuarios_activos' => $totalUsuariosActivos,
            'total_pacientes' => $totalPacientes,
            'total_nutricionistas' => $totalNutricionistas,
            'total_workspaces' => $totalWorkspaces
        ], 'KPIs obtenidos con éxito', 200);
    }

    public function crearWorkspace(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $workspace = new Workspace();
        $workspace->name = $data['name'];
        $workspace->is_active = true;
        $workspace->save();

        return $this->successResponse([
            'workspace' => $workspace
        ], 'Workspace creado con éxito', 201);
    }

    public function asignarMiembro(Request $request)
    {
        $data = $request->validate([
            'workspace_id' => 'required|integer|exists:workspaces,id',
            'user_id' => 'required|integer|exists:users,id',
            'rol' => 'required|string|in:Paciente,Nutricionista'
        ]);

        $workspace = Workspace::findOrFail($data['workspace_id']);

        $yaEstaEnEsteWorkspace = $workspace->members()
            ->where('users.id', $data['user_id'])
            ->exists();

        if ($yaEstaEnEsteWorkspace) {
            return response()->json([
                'status' => 'error',
                'message' => 'Este usuario ya se encuentra asignado a este espacio de trabajo.'
            ], 400);
        }

        if ($data['rol'] === 'Paciente') {
            $yaTieneWorkspace = \DB::table('workspace_members')
                ->where('user_id', $data['user_id'])
                ->where('member_role', 'Paciente')
                ->exists();

            if ($yaTieneWorkspace) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Este paciente ya se encuentra asignado a un espacio de trabajo. No puede estar en más de uno.'
                ], 400);
            }

            $existePacienteEnWorkspace = $workspace->members()
                ->wherePivot('member_role', 'Paciente')
                ->exists();

            if ($existePacienteEnWorkspace) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Este workspace ya tiene un paciente asignado. Solo se permite uno.'
                ], 400);
            }
        }

        $workspace->members()->attach($data['user_id'], [
            'member_role' => $data['rol'],
            'is_active' => true
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Miembro asignado con éxito.'
        ], 200);
    }

    public function listarWorkspaces(Request $request)
    {
        $buscar = $request->input('buscar', '');
        $user = $request->user();

        $query = Workspace::query();
        if ($user->roles()->where('name', 'Nutricionista')->exists()) {
            $query->whereHas('members', function ($q) use ($user) {
                $q->where('users.id', $user->id);
            });
        }
        if (!empty($buscar)) {
            $query->where('name', 'LIKE', "%{$buscar}%");
        }

        $workspaces = $query->orderBy('name', 'asc')->get();

        return response()->json([
            'status' => 'Success',
            'message' => 'Workspaces filtrados y obtenidos con éxito.',
            'data' => $workspaces
        ], 200);
    }

    public function eliminarMiembro(Request $request)
    {
        $data = $request->validate([
            'workspace_id' => 'required|integer|exists:workspaces,id',
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $workspace = Workspace::findOrFail($data['workspace_id']);
        $miembro = $workspace->members()->where('users.id', $data['user_id'])->first();

        if (!$miembro) {
            return response()->json([
                'status' => 'error',
                'message' => 'El usuario no pertenece a este espacio de trabajo.'
            ], 404);
        }

        if ($miembro->pivot->member_role === 'Paciente') {
            return response()->json([
                'status' => 'error',
                'message' => 'No se puede remover al paciente desde este módulo.'
            ], 400);
        }

        $workspace->members()->detach($data['user_id']);

        return $this->successResponse([], 'Miembro removido con éxito.', 200);
    }

    public function verWorkspace(Request $request)
    {
        $data = $request->validate([
            'id' => ['required', 'integer', 'exists:workspaces,id'],
        ]);

        $workspace = Workspace::with([
            'members' => function ($q) {
                $q->select('users.id', 'users.name', 'users.last_name', 'users.email')
                    ->withPivot('member_role', 'is_active');
            },
            'clinicalHistory'
        ])->find($data['id']);

        return $this->successResponse($workspace, 'Detalle del workspace obtenido con éxito.', 200);
    }


    public function obtenerWorkspacePaciente(Request $request)
    {
        $user = $request->user();
        $workspace = $user->workspaces()
            ->where('workspaces.is_active', true)
            ->first();

        if (!$workspace) {
            return response()->json([
                'status' => 'Error',
                'message' => 'Aún no tienes un espacio de trabajo asignado. Contacta a tu nutricionista.',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'Success',
            'message' => 'Workspace obtenido con éxito.',
            'data' => [
                'id'          => $workspace->id,
                'name'        => $workspace->name,
                // Recuperamos el rol de la tabla pivote de forma segura
                'member_role' => $workspace->pivot->member_role ?? $workspace->pivot->rol ?? 'Miembro'
            ]
        ], 200);
    }
}

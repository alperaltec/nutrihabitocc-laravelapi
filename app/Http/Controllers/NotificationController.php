<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Illuminate\Support\Facades\Log;
use Exception;

class NotificationController extends Controller
{

    public function enviarNotificacionesInmediatas()
    {
        try {
            $resultado = $this->procesarEnvioMasivo();

            return response()->json([
                'status' => 'success',
                'message' => 'Proceso de envío masivo finalizado basado en dispositivos nativos.',
                'detalles' => $resultado
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Ocurrió un error general en el envío masivo.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function procesarEnvioMasivo()
    {
        $messaging = app('firebase.messaging');

        $usuarios = User::where('is_active', true)
            ->with(['devices', 'roles'])
            ->get();

        $enviadosPacientes = 0;
        $enviadosNutricionistas = 0;
        $enviadosOtrosRoles = 0;
        $tokensFallidosOmitidos = 0;
        $detallesErrores = [];

        foreach ($usuarios as $usuario) {
            if ($usuario->devices->isEmpty()) {
                continue;
            }

            $rolesDelUsuario = $usuario->roles->pluck('name')->map(function ($name) {
                return trim(strtolower($name));
            })->toArray();
            $esPaciente = in_array('paciente', $rolesDelUsuario);
            $esNutricionista = in_array('nutricionista', $rolesDelUsuario);
            if ($esPaciente) {
                $title = "¡Hola {$usuario->name}! 🍽️";
                $body = "Es hora de revisar tu cronograma. No olvides cumplir con tu plan nutricional de hoy.";
                $tipoUsuario = 'paciente';
            } elseif ($esNutricionista) {
                $title = "Recordatorio de Supervisión 📋";
                $body = "Hola {$usuario->name}, no te olvides de supervisar el progreso de tus pacientes asignados.";
                $tipoUsuario = 'nutricionista';
            } else {
                $title = "Recordatorio del Sistema 📲";
                $body = "Hola {$usuario->name}, recuerda revisar las actividades pendientes del día en la plataforma.";
                $tipoUsuario = 'general';
            }

            foreach ($usuario->devices as $device) {

                if (empty($device->device_token)) {
                    continue;
                }

                $message = CloudMessage::fromArray([
                    'token' => $device->device_token,
                    'data' => [
                        'title' => $title,
                        'body' => $body,
                        'tipo_usuario' => $tipoUsuario,
                        'origen' => 'recordatorio_sistema'
                    ],
                    'android' => [
                        'priority' => 'high',
                        'ttl' => '3600s',
                    ],
                    'apns' => [
                        'headers' => [
                            'apns-priority' => '10',
                        ],
                        'payload' => [
                            'aps' => [
                                'content-available' => 1,
                                'badge' => 1,
                            ],
                        ],
                    ],
                ]);

                try {
                    $messaging->send($message);
                    if ($tipoUsuario === 'paciente') {
                        $enviadosPacientes++;
                    } elseif ($tipoUsuario === 'nutricionista') {
                        $enviadosNutricionistas++;
                    } else {
                        $enviadosOtrosRoles++;
                    }

                } catch (Exception $e) {
                    $tokensFallidosOmitidos++;
                    $detallesErrores[] = [
                        'user_id' => $usuario->id,
                        'device_id' => $device->id,
                        'device_os' => $device->device_os,
                        'error' => $e->getMessage()
                    ];
                }
            }
        }

        return [
            'total_notificaciones_pacientes' => $enviadosPacientes,
            'total_notificaciones_nutricionistas' => $enviadosNutricionistas,
            'total_notificaciones_otros_roles' => $enviadosOtrosRoles,
            'dispositivos_fallidos_omitidos' => $tokensFallidosOmitidos,
            'reporte_errores' => $detallesErrores
        ];
    }
}

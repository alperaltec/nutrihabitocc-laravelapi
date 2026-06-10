<?php

namespace App\Http\Controllers;

use App\Models\ClinicalHistory;
use App\Models\Workspace;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ClinicalHistoryController extends Controller
{
    use ApiResponse;


    public function crearHistoriaClinica(Request $request)
    {
        $data = $request->validate([
            'id' => 'nullable|integer|exists:clinical_histories,id',
            'workspace_id' => 'required|integer|exists:workspaces,id',
            'user_id' => 'required|integer|exists:users,id',
            'plantilla_formulario_id' => 'required|integer|exists:plantilla_formularios,id',
            'content_data' => 'required|array'
        ]);


        $historia = ClinicalHistory::updateOrCreate(
            [
                'id' => $data['id'] ?? null
            ],
            [
                'workspace_id' => $data['workspace_id'],
                'user_id' => $data['user_id'],
                'plantilla_formulario_id' => $data['plantilla_formulario_id'],
                'content_data' => $data['content_data']
            ]
        );

        return $this->successResponse($historia, 'Historia clínica sincronizada correctamente.', 201);
    }


    public function obtenerHistorialPaciente(Request $request)
    {
        $data = $request->validate([
            'id'                      => 'nullable|integer|exists:clinical_histories,id',
            'workspace_id'            => 'required|integer|exists:workspaces,id',
            'user_id'                 => 'required|integer|exists:users,id',
            'plantilla_formulario_id' => 'required|integer|exists:plantilla_formularios,id'
        ]);

        $query = ClinicalHistory::with('workspace')
            ->where('workspace_id', $data['workspace_id'])
            ->where('user_id', $data['user_id'])
            ->where('plantilla_formulario_id', $data['plantilla_formulario_id']);

        if (!empty($data['id'])) {
            $historial = $query->where('id', $data['id'])->first();
        } else {
            $historial = $query->latest()->first();
        }

        if (!$historial) {
            return $this->successResponse(null, 'El expediente solicitado no existe o no registra antecedentes.', 200);
        }

        return $this->successResponse($historial, 'Expediente clínico obtenido con éxito.', 200);
    }


    public function listarHistorialPaciente(Request $request)
    {
        $request->validate([
            'workspace_id' => 'required|integer',
            'user_id' => 'required|integer',
        ]);
        $fichas = ClinicalHistory::where('workspace_id', $request->workspace_id)
            ->where('user_id', $request->user_id)
            ->select('id', 'plantilla_formulario_id', 'created_at')
            ->with('plantilla:id,name')
            ->orderBy('created_at', 'desc')
            ->get();

        $resultado = $fichas->map(function ($ficha) {
            return [
                'id' => $ficha->id,
                'plantilla_id' => $ficha->plantilla_formulario_id,
                'nombre_plantilla' => $ficha->plantilla->name ?? 'Historia Clínica Nutricional',
                'created_at' => $ficha->created_at->toIso8601String(),
            ];
        });

        return response()->json([
            'status' => 'Success',
            'message' => 'Listado de fichas obtenido con éxito.',
            'data' => $resultado
        ], 200);
    }
}

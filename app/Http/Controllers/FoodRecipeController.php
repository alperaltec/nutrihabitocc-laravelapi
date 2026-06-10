<?php

namespace App\Http\Controllers;

use App\Models\PlanNutricional;
use App\Models\Receta;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class FoodRecipeController extends Controller
{
    use ApiResponse;

    public function listarRecetas(Request $request)
    {
        $recetas = Receta::where('is_active', true)->latest()->get();

        return $this->successResponse($recetas, 'Catálogo de recetas obtenido con éxito.', 200);
    }

    public function crearReceta(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'calorias' => ['required', 'integer', 'min:0'],
            'informacion' => ['required', 'array'],
            'informacion.macronutrientes' => ['required', 'array'],
            'informacion.ingredientes' => ['required', 'array'],
            'informacion.preparacion' => ['required', 'array'],
        ]);

        $receta = Receta::create([
            'name' => $data['name'],
            'calorias' => $data['calorias'],
            'informacion' => $data['informacion'],
            'is_active' => true
        ]);

        return $this->successResponse([], 'Receta creada con éxito en el catálogo maestro.', 201);
    }


    public function crearPlanNutricional(Request $request)
    {
        $data = $request->validate([
            'workspace_id' => ['required', 'integer', 'exists:workspaces,id'],
            'name' => ['required', 'string', 'max:255'],
            'fecha_inicio' => ['required', 'date'],
            'fecha_fin' => ['required', 'date', 'after_or_equal:fecha_inicio'],
        ]);

        $plan = PlanNutricional::create([
            'workspace_id' => $data['workspace_id'],
            'name' => $data['name'],
            'fecha_inicio' => $data['fecha_inicio'],
            'fecha_fin' => $data['fecha_fin'],
            'is_active' => true
        ]);

        return $this->successResponse($plan, 'Plan nutricional mensual creado e inicializado con éxito.', 201);
    }


    public function agregarRecetaAPlan(Request $request)
    {
        $data = $request->validate([
            'plan_nutricional_id' => ['required', 'integer', 'exists:plan_nutricionals,id'],
            'receta_id' => ['required', 'integer', 'exists:recetas,id'],
            'semana' => ['required', 'integer', 'min:1', 'max:5'], // Semana 1, 2, 3, 4 o 5
            'day' => ['required', 'string', 'in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado,Domingo'],
            'tipo_comida' => ['required', 'string', 'in:Desayuno,Media Mañana,Almuerzo,Media Tarde,Cena,Snack'],
            'notas' => ['nullable', 'string']
        ]);

        $plan = PlanNutricional::findOrFail($data['plan_nutricional_id']);
        $plan->recetas()->attach($data['receta_id'], [
            'semana' => $data['semana'],
            'day' => $data['day'],
            'tipo_comida' => $data['tipo_comida'],
            'notas' => $data['notas'] ?? null,
            'is_active' => true
        ]);

        return $this->successResponse([], 'Receta añadida al calendario del plan con éxito.', 200);
    }


    public function obtenerPlanWorkspace(Request $request)
    {
        $data = $request->validate([
            'workspace_id' => ['required', 'integer', 'exists:workspaces,id']
        ]);

        $planes = PlanNutricional::with(['recetas' => function ($query) {
            $query->where('plan_nutricional_recetas.is_active', true);
        }])
            ->where('workspace_id', $data['workspace_id'])
            ->where('is_active', true)
            ->where('fecha_fin', '>=', now()->format('Y-m-d'))
            ->get(); // <--- AQUÍ EL CAMBIO

        if ($planes->isEmpty()) {
            return $this->successResponse(null, 'Este espacio de trabajo no cuenta con planes activos.', 200);
        }
        $listaDePlanes = $planes->map(function ($plan) {

            $cronogramaSemanal = $plan->recetas->groupBy(function ($receta) {
                return 'semana_' . $receta->pivot->semana;
            })->map(function ($recetasDeLaSemana) {
                return $recetasDeLaSemana->groupBy(function ($receta) {
                    return $receta->pivot->day;
                })->map(function ($recetasDelDia) {
                    return $recetasDelDia->keyBy(function ($receta) {
                        return $receta->pivot->tipo_comida;
                    })->map(function ($receta) {
                        return [
                            'receta_id' => $receta->id,
                            'name' => $receta->name,
                            'calorias' => $receta->calorias,
                            'informacion' => $receta->informacion,
                            'notas' => $receta->pivot->notas,
                            'plan_receta_id' => $receta->pivot->id
                        ];
                    });
                });
            });

            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'workspace_id' => $plan->workspace_id,
                'fecha_inicio' => $plan->fecha_inicio,
                'fecha_fin' => $plan->fecha_fin,
                'cronograma_semanal' => $cronogramaSemanal
            ];
        });

        return $this->successResponse($listaDePlanes, 'Planes nutricionales obtenidos correctamente.', 200);
    }


    public function listarPlanesWorkspace(Request $request)
    {
        $data = $request->validate([
            'workspace_id' => ['required', 'integer', 'exists:workspaces,id']
        ]);

        $planes = PlanNutricional::where('workspace_id', $data['workspace_id'])
            ->latest()
            ->get()
            ->map(function ($plan) {
                $hoy = now()->format('Y-m-d');
                $plan->is_expired = $plan->fecha_fin < $hoy;
                return $plan;
            });

        return $this->successResponse($planes, 'Historial de planes obtenido con éxito.', 200);
    }


    public function desactivarPlanNutricional(Request $request)
    {
        $data = $request->validate([
            'plan_nutricional_id' => ['required', 'integer', 'exists:plan_nutricionals,id']
        ]);

        $plan = PlanNutricional::findOrFail($data['plan_nutricional_id']);

        // Cambiamos el estado a falso (Desactivado/Bloqueado)
        $plan->update(['is_active' => false]);

        return $this->successResponse($plan, 'El plan nutricional ha sido desactivado y bloqueado correctamente.', 200);
    }


    public function obtenerDetalleCronograma(Request $request)
    {
        $request->validate([
            'plan_nutricional_id' => ['required', 'integer', 'exists:plan_nutricionals,id']
        ]);
        $plan = PlanNutricional::with(['recetas' => function ($query) {
            $query->where('plan_nutricional_recetas.is_active', true);
        }])->findOrFail($request->plan_nutricional_id);
        $cronograma = $this->procesarCronograma($plan->recetas);

        return $this->successResponse([
            'id' => $plan->id,
            'name' => $plan->name,
            'cronograma' => $cronograma
        ], 'Detalle del plan obtenido.', 200);
    }

    private function procesarCronograma($recetas)
    {
        \Log::info("Total recetas recibidas: " . $recetas->count());

        foreach ($recetas as $r) {
            \Log::info("Receta ID: {$r->id} - Semana en DB: " . ($r->pivot->semana ?? 'NULL'));
        }
        return $recetas->groupBy(function ($receta) {
            // Forzamos a entero para que siempre sea 'semana_1', 'semana_2', etc.
            $semana = (int) ($receta->pivot->semana ?? 1);
            return 'semana_' . $semana;
        })->map(function ($recetasDeLaSemana) {
            return $recetasDeLaSemana->groupBy(function ($receta) {
                // Aseguramos que el día sea una cadena válida
                return $receta->pivot->day ?? 'Lunes';
            })->map(function ($recetasDelDia) {
                return $recetasDelDia->keyBy(function ($receta) {
                    // Aseguramos que el tipo de comida sea una cadena
                    return $receta->pivot->tipo_comida ?? 'Desayuno';
                })->map(function ($receta) {
                    return [
                        'receta_id' => $receta->id,
                        'name' => $receta->name,
                        'calorias' => $receta->calorias,
                        'informacion' => $receta->informacion,
                        'notas' => $receta->pivot->notas,
                        'plan_receta_id' => $receta->pivot->id
                    ];
                });
            });
        });
    }
}

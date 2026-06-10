<?php

namespace App\Http\Controllers;

use App\Models\PlantillaFormulario;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class PlantillaFormularioController extends Controller
{
    use ApiResponse;

    public function listarPlantillas()
    {
        $plantillas = PlantillaFormulario::select('id', 'name', 'version', 'created_at')->latest()->get();
        return $this->successResponse($plantillas, 'Plantillas obtenidas con éxito.', 200);
    }

    public function detallePlantilla(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|integer|exists:plantilla_formularios,id'
        ]);

        $plantilla = PlantillaFormulario::findOrFail($data['id']);
        return $this->successResponse($plantilla, 'Estructura de la plantilla obtenida.', 200);
    }


    public function guardarPlantilla(Request $request)
    {
        $data = $request->validate([
            'name'         => 'required|string|max:255',
            'version'      => 'required|string',
            'content_data' => 'required|array'
        ]);

        $plantilla = PlantillaFormulario::create([
            'name'         => $data['name'],
            'version'      => $data['version'],
            'content_data' => $data['content_data']
        ]);

        return $this->successResponse($plantilla, 'Plantilla de formulario guardada con éxito.', 201);
    }
}

<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PlantillaFormularioController;
use App\Http\Controllers\ClinicalHistoryController;
use App\Http\Controllers\FoodRecipeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

Route::post('/registro', [AuthController::class, 'registro']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/sendcode', [AuthController::class, 'sendCode']);
Route::post('/resetpassword', [AuthController::class, 'resetPassword']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/listarWorkspaces', [UserController::class, 'listarWorkspaces']);
    Route::post('/crearWorkspace', [UserController::class, 'crearWorkspace']);
    Route::post('/verworkspace', [UserController::class, 'verWorkspace']);

    Route::get('/kpis', [UserController::class, 'kpis']);
    Route::post('/listadoUsuarios', [UserController::class, 'listadoUsuarios']);
    Route::post('/actualizarpasswordUsuario', [UserController::class, 'actualizarpasswordUsuario']);
    Route::post('/modificarestadoUsuario', [UserController::class, 'modificarestadoUsuario']);
    Route::post('/crearactualizarperfil', [UserController::class, 'crearactualizarperfil']);
    Route::post('/obtenerperfil',[UserController::class, 'obtenerPerfil']);
    Route::post('/actualizardatospersonales', [UserController::class, 'actualizarDatosPersonales']);

    Route::post('/asignarmiembro', [UserController::class, 'asignarMiembro']);
    Route::get('/listadousuariospacientes', [UserController::class, 'listadoUsuariosPacientes']);
    Route::get('/listadousuariosnutricionistas', [UserController::class, 'listadoUsuariosNutricionistas']);
    Route::post('/eliminarmiembro', [UserController::class, 'eliminarMiembro']);

    Route::post('/guardarplantilla', [PlantillaFormularioController::class, 'guardarPlantilla']);
    Route::post('/detalleplantilla', [PlantillaFormularioController::class, 'detallePlantilla']);
    Route::post('/listarplantillas', [PlantillaFormularioController::class, 'listarPlantillas']);

    Route::post('/obtenerhistorialpaciente', [ClinicalHistoryController::class, 'obtenerHistorialPaciente']);
    Route::post('/crearhistoriaclinica', [ClinicalHistoryController::class, 'crearHistoriaClinica']);
    Route::post('/listarhistorialpaciente', [ClinicalHistoryController::class, 'listarHistorialPaciente']);

    Route::post('/crearreceta', [FoodRecipeController::class, 'crearReceta']);
    Route::post('/crearplannutricional', [FoodRecipeController::class, 'crearPlanNutricional']);
    Route::post('/agregarrecetaplan', [FoodRecipeController::class, 'agregarRecetaAPlan']);
    Route::post('/obtenerplanworkspace', [FoodRecipeController::class, 'obtenerPlanWorkspace']);
    Route::get('/listarrecetas', [FoodRecipeController::class, 'listarRecetas']);
    Route::post('/listarplanesworkspace', [FoodRecipeController::class, 'listarPlanesWorkspace']);
    Route::post('/desactivarplannutricional', [FoodRecipeController::class, 'desactivarPlanNutricional']);
    Route::post('/obtenerdetallecronograma', [FoodRecipeController::class, 'obtenerDetalleCronograma']);

    Route::post('/obtenerworkspacepaciente', [UserController::class, 'obtenerWorkspacePaciente']);

    Route::post('/savedevice', [UserController::class, 'savedevice']);
    Route::get('/enviarNotificacionesInmediatas', [NotificationController::class, 'enviarNotificacionesInmediatas']);
});



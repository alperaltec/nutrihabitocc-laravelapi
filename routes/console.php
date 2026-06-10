<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\NotificationController;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');


$enviarRecordatorio = function () {
    $controller = app(NotificationController::class);
    $controller->procesarEnvioMasivo();
};

Schedule::call($enviarRecordatorio)->at('08:00')->timezone('America/Guayaquil');
Schedule::call($enviarRecordatorio)->at('13:00')->timezone('America/Guayaquil');
Schedule::call($enviarRecordatorio)->at('17:00')->timezone('America/Guayaquil');
Schedule::call($enviarRecordatorio)->at('21:00')->timezone('America/Guayaquil');

<?php

use Illuminate\Support\Facades\Route;
use Src\manager\ambiente\infrastructure\controllers\ListAllAmbienteGETController;
use Src\manager\ambiente\infrastructure\controllers\SearchSalidaAmbienteGETController;

Route::prefix('manager_ambiente')->group(function () {
//     // Simple route example
 Route::get('/', [ListAllAmbienteGETController::class, 'index']);
 Route::get('salida/{salida}', [SearchSalidaAmbienteGETController::class, 'index']);

});
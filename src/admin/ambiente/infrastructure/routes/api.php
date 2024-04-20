<?php

use Illuminate\Support\Facades\Route;
use Src\admin\ambiente\infrastructure\controllers\ListAllAmbienteGETController;
use Src\admin\ambiente\infrastructure\controllers\SearchSalidaAmbienteGETController;

Route::prefix('admin_ambiente')->group(function () {
//     // Simple route example
 Route::get('/', [ListAllAmbienteGETController::class, 'index']);
 Route::get('salida/{salida}', [SearchSalidaAmbienteGETController::class, 'index']);

});
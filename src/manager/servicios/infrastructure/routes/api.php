<?php

use Src\manager\servicios\infrastructure\controllers\StoreServiciosPOSTController;
use Illuminate\Support\Facades\Route;
use Src\manager\servicios\infrastructure\controllers\UpdatePagoCuotasPUTController;
use Src\manager\servicios\infrastructure\controllers\InhabilitarServicioDELETEController;
use Src\manager\servicios\infrastructure\controllers\ListAllRegistroServiciosGETController;
use Src\manager\servicios\infrastructure\controllers\ListAllServiciosGETController;
use Src\manager\servicios\infrastructure\controllers\StoreRegistroServicioPOSTController;
use Src\manager\servicios\infrastructure\controllers\UpdateEntregaCertificadoPUTController;
use Src\manager\servicios\infrastructure\controllers\UpdateServiciosPUTController;

Route::prefix('manager_servicios')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/servicios', [ListAllServiciosGETController::class, 'index']);
        Route::post('/servicios', [StoreServiciosPOSTController::class, 'index']);
        
        Route::post('/registro-servicios', [StoreRegistroServicioPOSTController::class, 'index']);
        Route::get('/registro-servicios', [ListAllRegistroServiciosGETController::class, 'index']);
        //Route::post('/', [StoreCertificadoAntecedentesPOSTController::class, 'index']);
        Route::put('/pago-cuota/{programacion}', [UpdatePagoCuotasPUTController::class, 'index']);
        Route::patch('/entregar-certificado/{programacion}', [UpdateEntregaCertificadoPUTController::class, 'index']);
    });
});

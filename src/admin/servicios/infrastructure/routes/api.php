<?php

use Src\admin\servicios\infrastructure\controllers\StoreServiciosPOSTController;
use Illuminate\Support\Facades\Route;
use Src\admin\servicios\infrastructure\controllers\UpdatePagoCuotasPUTController;
use Src\admin\servicios\infrastructure\controllers\InhabilitarServicioDELETEController;
use Src\admin\servicios\infrastructure\controllers\ListAllRegistroServiciosGETController;
use Src\admin\servicios\infrastructure\controllers\ListAllServiciosGETController;
use Src\admin\servicios\infrastructure\controllers\StoreRegistroServicioPOSTController;
use Src\admin\servicios\infrastructure\controllers\UpdateEntregaCertificadoPUTController;
use Src\admin\servicios\infrastructure\controllers\UpdateServiciosPUTController;

Route::prefix('admin_servicios')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/servicios', [ListAllServiciosGETController::class, 'index']);
        Route::post('/servicios', [StoreServiciosPOSTController::class, 'index']);
        Route::put('/servicios/{servicio}', [UpdateServiciosPUTController::class, 'index']);
        Route::delete('/servicios/{servicio}', [InhabilitarServicioDELETEController::class, 'index']);
        
        Route::post('/registro-servicios', [StoreRegistroServicioPOSTController::class, 'index']);
        Route::get('/registro-servicios', [ListAllRegistroServiciosGETController::class, 'index']);
        //Route::post('/', [StoreCertificadoAntecedentesPOSTController::class, 'index']);
        Route::put('/pago-cuota/{programacion}', [UpdatePagoCuotasPUTController::class, 'index']);
        Route::patch('/entregar-certificado/{programacion}', [UpdateEntregaCertificadoPUTController::class, 'index']);
    });
});

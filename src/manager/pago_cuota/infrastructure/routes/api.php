<?php

use Illuminate\Support\Facades\Route;
use Src\manager\pago_cuota\infrastructure\controllers\ListIngresosMesGETController;
use Src\manager\pago_cuota\infrastructure\controllers\ListMovimientosMesGETController;
use Src\manager\pago_cuota\infrastructure\controllers\ListPagoCuotaGETController;
use Src\manager\pago_cuota\infrastructure\controllers\StorePagoCuotaPOSTController;
use Src\manager\pago_cuota\infrastructure\validators\StorePagoCuotaPOSTRequest;

Route::prefix('manager_pago')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/', [ListIngresosMesGETController::class, 'index']);
        Route::get('/chart-pie', [ListMovimientosMesGETController::class, 'index']);
        Route::post('/', [StorePagoCuotaPOSTController::class, 'index']);
        Route::get('/listar-matricula', [ListPagoCuotaGETController::class, 'index']);
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Src\admin\pago_cuota\infrastructure\controllers\ListIngresosMesGETController;
use Src\admin\pago_cuota\infrastructure\controllers\ListMovimientosMesGETController;
use Src\admin\pago_cuota\infrastructure\controllers\ListPagoCuotaGETController;
use Src\admin\pago_cuota\infrastructure\controllers\StorePagoCuotaPOSTController;
use Src\admin\pago_cuota\infrastructure\validators\StorePagoCuotaPOSTRequest;

Route::prefix('admin_pago')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/', [ListIngresosMesGETController::class, 'index']);
        Route::get('/chart-pie', [ListMovimientosMesGETController::class, 'index']);
        Route::post('/', [StorePagoCuotaPOSTController::class, 'index']);
        Route::get('/listar-matricula', [ListPagoCuotaGETController::class, 'index']);
    });
});

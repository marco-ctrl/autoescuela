<?php

use Illuminate\Support\Facades\Route;
use Src\manager\caja\infrastructure\controllers\ListGetAllEgresosGETController;
use Src\manager\caja\infrastructure\controllers\ListGetAllIngresosGETController;
use Src\manager\caja\infrastructure\controllers\StoreEgresosPOSTController;
use Src\manager\caja\infrastructure\controllers\StoreIngresosPOSTController;

Route::prefix('manager_caja')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/ingresos', [ListGetAllIngresosGETController::class, 'index']);
        Route::post('/ingresos', [StoreIngresosPOSTController::class, 'index']);
        
        Route::get(('/egresos'), [ListGetAllEgresosGETController::class, 'index']);
        Route::post('/egresos', [StoreEgresosPOSTController::class, 'index']);
    });
});

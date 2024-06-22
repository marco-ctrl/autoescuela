<?php

use Illuminate\Support\Facades\Route;
use Src\admin\caja\infrastructure\controllers\ListGetAllEgresosGETController;
use Src\admin\caja\infrastructure\controllers\ListGetAllIngresosGETController;
use Src\admin\caja\infrastructure\controllers\StoreEgresosPOSTController;
use Src\admin\caja\infrastructure\controllers\StoreIngresosPOSTController;

Route::prefix('admin_caja')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/ingresos', [ListGetAllIngresosGETController::class, 'index']);
        Route::post('/ingresos', [StoreIngresosPOSTController::class, 'index']);
        
        Route::get(('/egresos'), [ListGetAllEgresosGETController::class, 'index']);
        Route::post('/egresos', [StoreEgresosPOSTController::class, 'index']);
    });
});

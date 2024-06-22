<?php

use Illuminate\Support\Facades\Route;
use Src\manager\producto\infrastructure\controllers\AutoCompleteProductoEgresoGETController;
use Src\manager\producto\infrastructure\controllers\AutoCompleteProductoIngresoGETController;

Route::prefix('manager_producto')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/autocomplete', [AutoCompleteProductoIngresoGETController::class, 'index']);
        Route::get('/autocomplete/egresos', [AutoCompleteProductoEgresoGETController::class, 'index']);
    });
});

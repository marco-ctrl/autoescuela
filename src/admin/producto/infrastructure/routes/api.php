<?php

use Illuminate\Support\Facades\Route;
use Src\admin\producto\infrastructure\controllers\AutoCompleteProductoIngresoGETController;

Route::prefix('admin_producto')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/autocomplete', [AutoCompleteProductoIngresoGETController::class, 'index']);
    });
});

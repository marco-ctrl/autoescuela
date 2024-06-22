<?php

use Illuminate\Support\Facades\Route;
use Src\admin\usuario\infrastructure\controllers\ListAllUsuarioGETController;

Route::prefix('admin_usuario')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/', [ListAllUsuarioGETController::class, 'index']);
    });
});

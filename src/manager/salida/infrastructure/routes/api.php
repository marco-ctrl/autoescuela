<?php

use Illuminate\Support\Facades\Route;
use Src\admin\salida\infrastructure\controllers\ListAllSalidaGETController;


Route::prefix('admin_salida')->group(function () {
    Route::get('/', [ListAllSalidaGETController::class, 'index']);
});
<?php

use Illuminate\Support\Facades\Route;
use Src\admin\salida\infrastructure\controllers\ListAllSalidaGETController;


Route::prefix('manager_salida')->group(function () {
    Route::get('/', [ListAllSalidaGETController::class, 'index']);
});
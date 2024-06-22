<?php

use Illuminate\Support\Facades\Route;
use Src\manager\categoria\infrastructure\controllers\ListAllCategoriaGETController;

Route::prefix('manager_categoria')->group(function () {
 Route::get('/{edad}', [ListAllCategoriaGETController::class, 'index']);
});
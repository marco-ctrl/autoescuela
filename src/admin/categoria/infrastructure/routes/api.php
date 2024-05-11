<?php

use Illuminate\Support\Facades\Route;
use Src\admin\categoria\infrastructure\controllers\ListAllCategoriaGETController;

Route::prefix('admin_categoria')->group(function () {
 Route::get('/{edad}', [ListAllCategoriaGETController::class, 'index']);
});
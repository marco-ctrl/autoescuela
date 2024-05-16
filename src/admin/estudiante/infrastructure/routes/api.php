<?php

use Illuminate\Support\Facades\Route;
use Src\admin\estudiante\infrastructure\controllers\AutoCompleteEstudianteGETController;
use Src\admin\estudiante\infrastructure\controllers\ListAllEstudianteGETController;
use Src\admin\estudiante\infrastructure\controllers\ShowEstudianteGETController;
use Src\admin\estudiante\infrastructure\controllers\StoreEstudiantePOSTController;
use Src\admin\estudiante\infrastructure\controllers\UpdateEstudiantePUTController;

Route::prefix('admin_estudiante')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/', [ListAllEstudianteGETController::class, 'index']);
        Route::get('/{estudiante}/show', [ShowEstudianteGETController::class, 'index']);
        Route::get('/autocomplete', [AutoCompleteEstudianteGETController::class, 'index']);
        Route::post('/', [StoreEstudiantePOSTController::class, 'index']);
        Route::put('/{estudiante}', [UpdateEstudiantePUTController::class, 'index']);
    });
});

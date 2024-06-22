<?php

use Illuminate\Support\Facades\Route;
use Src\manager\estudiante\infrastructure\controllers\AutoCompleteEstudianteGETController;
use Src\manager\estudiante\infrastructure\controllers\ListAllEstudianteGETController;
use Src\manager\estudiante\infrastructure\controllers\ShowEstudianteGETController;
use Src\manager\estudiante\infrastructure\controllers\StoreEstudiantePOSTController;
use Src\manager\estudiante\infrastructure\controllers\UpdateEstudiantePUTController;

Route::prefix('manager_estudiante')->group(function () {
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

<?php

use Illuminate\Support\Facades\Route;
use Src\manager\matricula\infrastructure\controllers\ListAllMatriculaGetController;
use Src\manager\matricula\infrastructure\controllers\StoreMatriculaPOSTController;
use Src\manager\matricula\infrastructure\controllers\UpdateEvaluacionPUTController;

Route::prefix('manager_matricula')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/', [ListAllMatriculaGetController::class, 'index']);
        Route::post('/', [StoreMatriculaPOSTController::class, 'index']);
        Route::put('/evaluacion/{matricula}', [UpdateEvaluacionPUTController::class, 'index']);
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Src\admin\matricula\infrastructure\controllers\ListAllMatriculaGetController;
use Src\admin\matricula\infrastructure\controllers\StoreMatriculaPOSTController;
use Src\admin\matricula\infrastructure\controllers\UpdateEvaluacionPUTController;

Route::prefix('admin_matricula')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/', [ListAllMatriculaGetController::class, 'index']);
        Route::post('/store', [StoreMatriculaPOSTController::class, 'index']);
        Route::put('/evaluacion/{matricula}', [UpdateEvaluacionPUTController::class, 'index']);
    });
});

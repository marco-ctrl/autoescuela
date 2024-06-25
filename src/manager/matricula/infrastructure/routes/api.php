<?php

use Illuminate\Support\Facades\Route;
use Src\manager\matricula\infrastructure\controllers\ListAllMatriculaGetController;
use Src\manager\matricula\infrastructure\controllers\StoreMatriculaPOSTController;
use Src\manager\matricula\infrastructure\controllers\UpdateAgregarCursoPUTController;
use Src\manager\matricula\infrastructure\controllers\UpdateAgregarEvaluacionPUTController;
use Src\manager\matricula\infrastructure\controllers\UpdateAgregarHorarioExtraPUTController;
use Src\manager\matricula\infrastructure\controllers\UpdateEvaluacionPUTController;
use Src\manager\matricula\infrastructure\controllers\UpdateMatriculaPUTController;

Route::prefix('manager_matricula')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/', [ListAllMatriculaGetController::class, 'index']);
        Route::post('/store', [StoreMatriculaPOSTController::class, 'index']);
       Route::put('/evaluacion/{matricula}', [UpdateEvaluacionPUTController::class, 'index']);
        Route::put('/horario-extra/{matricula}', [UpdateAgregarHorarioExtraPUTController::class, 'index']);
        Route::put('/agregar-evaluacion/{matricula}', [UpdateAgregarEvaluacionPUTController::class, 'index']);
        Route::put('/edit/{matricula}', [UpdateMatriculaPUTController::class, 'index']);
        Route::put('/agregar-curso/{matricula}', [UpdateAgregarCursoPUTController::class, 'index']);
    
    });
});

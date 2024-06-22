<?php

use Illuminate\Support\Facades\Route;
use Src\admin\matricula\infrastructure\controllers\ListAllMatriculaGetController;
use Src\admin\matricula\infrastructure\controllers\StoreMatriculaPOSTController;
use Src\admin\matricula\infrastructure\controllers\UpdateAgregarCursoPUTController;
use Src\admin\matricula\infrastructure\controllers\UpdateAgregarEvaluacionPUTController;
use Src\admin\matricula\infrastructure\controllers\UpdateAgregarHorarioExtraPUTController;
use Src\admin\matricula\infrastructure\controllers\UpdateEvaluacionPUTController;
use Src\admin\matricula\infrastructure\controllers\UpdateMatriculaPUTController;

Route::prefix('admin_matricula')->group(function () {
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

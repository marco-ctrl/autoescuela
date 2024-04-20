<?php

use Illuminate\Support\Facades\Route;
use Src\admin\horario\infrastructure\controllers\DestroyHorarioMatriculaDELETEController;
use Src\admin\horario\infrastructure\controllers\ListHorarioDocenteGETController;
use Src\admin\horario\infrastructure\controllers\ListHorarioMatriculaGETController;
use Src\admin\horario\infrastructure\controllers\StoreHorarioMatriculaPostController;

Route::prefix('admin_horario')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/matricula/{matricula}', [ListHorarioMatriculaGETController::class, 'index']);
        Route::get('/docente/{docente}', [ListHorarioDocenteGETController::class, 'index']);
        Route::post('/store', [StoreHorarioMatriculaPostController::class, 'index']);
        Route::delete('/{horario}', [DestroyHorarioMatriculaDELETEController::class, 'index']);
    });
});

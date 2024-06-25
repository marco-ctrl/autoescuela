<?php

use Illuminate\Support\Facades\Route;
use Src\manager\horario\infrastructure\controllers\DestroyHorarioMatriculaDELETEController;
use Src\manager\horario\infrastructure\controllers\ListHorarioDocenteGETController;
use Src\manager\horario\infrastructure\controllers\ListHorarioMatriculaGETController;
use Src\manager\horario\infrastructure\controllers\StoreHorarioMatriculaPOSTController;

Route::prefix('manager_horario')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/matricula/{matricula}', [ListHorarioMatriculaGETController::class, 'index']);
        Route::get('/docente/{docente}', [ListHorarioDocenteGETController::class, 'index']);
        Route::post('/store', [StoreHorarioMatriculaPOSTController::class, 'index']);
    });
});

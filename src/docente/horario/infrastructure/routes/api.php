<?php

use Illuminate\Support\Facades\Route;
use Src\docente\horario\infrastructure\controllers\ListHorarioAsistenciaGETController;
use Src\docente\horario\infrastructure\controllers\MarcarAsistenciaPUTController;

Route::prefix('docente_horario')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/docente/{usuario}/asistencia', [ListHorarioAsistenciaGETController::class, 'index']);
        Route::put('/horario-matricula/{horario}/update', [MarcarAsistenciaPUTController::class, 'index']);
    });
});

<?php

use Illuminate\Support\Facades\Route;
use Src\app\horario\infrastructure\controllers\ListHorarioGETController;

Route::prefix('estudiante_horario')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/estudiante/{usuario}', [ListHorarioGETController::class, 'index']);
    });
});

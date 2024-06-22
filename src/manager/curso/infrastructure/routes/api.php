<?php

use Illuminate\Support\Facades\Route;
use Src\manager\curso\infrastructure\controllers\AutoCompleteCursoGETController;
use Src\manager\curso\infrastructure\controllers\ShowCursoGETController;

Route::prefix('manager_curso')->group(function () {
//     // Simple route example
    Route::get('/autocomplete', [AutoCompleteCursoGETController::class, 'index']);
    Route::get('/{curso}', [ShowCursoGETController::class, 'index']);
});
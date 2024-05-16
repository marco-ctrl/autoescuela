<?php

use Illuminate\Support\Facades\Route;
use Src\admin\curso\infrastructure\controllers\AutoCompleteCursoGETController;
use Src\admin\curso\infrastructure\controllers\ShowCursoGETController;

Route::prefix('admin_curso')->group(function () {
//     // Simple route example
    Route::get('/autocomplete', [AutoCompleteCursoGETController::class, 'index']);
    Route::get('/{curso}', [ShowCursoGETController::class, 'index']);
});
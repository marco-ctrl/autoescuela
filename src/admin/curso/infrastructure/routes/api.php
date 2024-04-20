<?php

use Illuminate\Support\Facades\Route;
use Src\admin\curso\infrastructure\controllers\AutoCompleteCursoGETController;
use Src\admin\curso\infrastructure\controllers\ShowCursoGETController;

Route::prefix('admin_curso')->group(function () {
//     // Simple route example
    Route::get('/autocomplete', [AutoCompleteCursoGETController::class, 'index']);
    Route::get('/{curso}', [ShowCursoGETController::class, 'index']);

//     // Authenticated route example
//     // Route::middleware(['auth:sanctum'])->get('/', [ExampleGETController::class, 'index']);

//     // Group example for Authenticated routes
//     // Route::group([
//     //     'middleware' => 'auth:sanctum',
//     // ], function () {
//     //     Route::get('/', [ExampleGETController::class, 'index']);
//     //     // add as many authenticated routes as necessary
//     // });
});
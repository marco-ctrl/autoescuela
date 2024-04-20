<?php

use Illuminate\Support\Facades\Route;
use Src\admin\categoria\infrastructure\controllers\ListAllCategoriaGETController;

Route::prefix('admin_categoria')->group(function () {
//     // Simple route example
 Route::get('/', [ListAllCategoriaGETController::class, 'index']);

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
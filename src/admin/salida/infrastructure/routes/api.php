<?php

use Illuminate\Support\Facades\Route;
use Src\admin\salida\infrastructure\controllers\ListAllSalidaGETController;


Route::prefix('admin_salida')->group(function () {
//     // Simple route example
    Route::get('/', [ListAllSalidaGETController::class, 'index']);

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
<?php

use Illuminate\Support\Facades\Route;
use Src\manager\home\infrastructure\controllers\ListDatosDashboardGETController;

Route::prefix('manager_home')->group(function () {
 Route::group([
     'middleware' => 'auth:sanctum',
 ], function () {
     Route::get('/{usuario}', [ListDatosDashboardGETController::class, 'index']);
 });
});
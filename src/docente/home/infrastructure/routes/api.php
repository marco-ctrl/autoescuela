<?php

use Src\docente\home\infrastructure\controllers\ListDatosDashboardGETController;

Route::prefix('docente_home')->group(function () {
 Route::group([
     'middleware' => 'auth:sanctum',
 ], function () {
     Route::get('/{usuario}', [ListDatosDashboardGETController::class, 'index']);
 });
});
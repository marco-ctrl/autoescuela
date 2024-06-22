<?php

use Illuminate\Support\Facades\Route;
use Src\manager\docente\infrastructure\controllers\AutocompleteDocenteGETController;
use Src\manager\docente\infrastructure\controllers\ListPagoDocentesGETController;
use Src\manager\docente\infrastructure\controllers\StorePagoDocentePOSTController;

Route::prefix('manager_docente')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/pago-docente', [ListPagoDocentesGETController::class, 'index']);
        Route::get('/autocomplete', [AutocompleteDocenteGETController::class, 'index']);
        Route::post('/pago-docente', [StorePagoDocentePOSTController::class, 'index']);
    });
});

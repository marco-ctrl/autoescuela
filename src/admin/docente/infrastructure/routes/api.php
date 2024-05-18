<?php

use Illuminate\Support\Facades\Route;
use Src\admin\docente\infrastructure\controllers\AutocompleteDocenteGETController;
use Src\admin\docente\infrastructure\controllers\ListPagoDocentesGETController;
use Src\admin\docente\infrastructure\controllers\StorePagoDocentePOSTController;

Route::prefix('admin_docente')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/pago-docente', [ListPagoDocentesGETController::class, 'index']);
        Route::get('/autocomplete', [AutocompleteDocenteGETController::class, 'index']);
        Route::post('/pago-docente', [StorePagoDocentePOSTController::class, 'index']);
    });
});

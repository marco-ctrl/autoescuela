<?php

use Illuminate\Support\Facades\Route;
use Src\admin\docente\infrastructure\controllers\AutocompleteDocenteGETController;

 Route::prefix('admin_docente')->group(function () {
 Route::group([
     'middleware' => 'auth:sanctum',
 ], function () {
     Route::get('/autocomplete', [AutocompleteDocenteGETController::class, 'index']);
 });
});
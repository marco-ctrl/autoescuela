<?php

use Illuminate\Support\Facades\Route;
use Src\manager\sede\infrastructure\controllers\ListAllSedeGETController;

Route::prefix('manager_sede')->group(function () {
 Route::get('/', [ListAllSedeGETController::class, 'index']);
});
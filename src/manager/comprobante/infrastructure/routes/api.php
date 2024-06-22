<?php

use Illuminate\Support\Facades\Route;
use Src\admin\comprobante\infrastructure\controllers\ListAllComprobanteGETController;

Route::prefix('manager_comprobante')->group(function () {
 Route::get('/', [ListAllComprobanteGETController::class, 'index']);
});
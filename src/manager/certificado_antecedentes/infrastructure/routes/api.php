<?php

use Illuminate\Support\Facades\Route;
use Src\manager\certificado_antecedentes\infrastructure\controllers\ListAllCertificadoAntecedentesGETController;
use Src\manager\certificado_antecedentes\infrastructure\controllers\StoreCertificadoAntecedentesPOSTController;
use Src\manager\certificado_antecedentes\infrastructure\controllers\UpdateEntregaCertificadoPATCHController;
use Src\manager\certificado_antecedentes\infrastructure\controllers\UpdatePagoCuotasPUTController;

Route::prefix('manager_certificado_antecedentes')->group(function () {
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/', [ListAllCertificadoAntecedentesGETController::class, 'index']);
        Route::post('/', [StoreCertificadoAntecedentesPOSTController::class, 'index']);
        Route::put('/{programacion}', [UpdatePagoCuotasPUTController::class, 'index']);
        Route::patch('/{programacion}', [UpdateEntregaCertificadoPATCHController::class, 'index']);
    });
});

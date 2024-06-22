<?php

use Illuminate\Support\Facades\Route;
use Src\docente\horario\infrastructure\controllers\CantidadClasesMesGETController;
use Src\docente\horario\infrastructure\controllers\ListHorarioAsistenciaGETController;
use Src\docente\horario\infrastructure\controllers\ListHorarioGeneralPOSTController;
use Src\docente\horario\infrastructure\controllers\ListReporteAsistenciaGETController;
use Src\docente\horario\infrastructure\controllers\MarcarAsistenciaPUTController;
use Src\docente\horario\infrastructure\controllers\PdfReporteAsistenciaPOSTController;

Route::prefix('docente_horario')->group(function () {
    Route::post('/pdf/reporte-asistencia', [PdfReporteAsistenciaPOSTController::class, 'index'])->name('docente.pdf.reporte-asistencia');
    
    Route::group([
        'middleware' => 'auth:sanctum',
    ], function () {
        Route::get('/docente/{usuario}/asistencia', [ListHorarioAsistenciaGETController::class, 'index']);
        Route::put('/horario-matricula/{horario}/update', [MarcarAsistenciaPUTController::class, 'index']);
        Route::get('/cantidad-clases-mes/{usuario}', [CantidadClasesMesGETController::class, 'index']);
        Route::post('/reporte-general', [ListHorarioGeneralPOSTController::class, 'index']);
        Route::post('/reporte-asistencia', [ListReporteAsistenciaGETController::class, 'index']);
    });
});

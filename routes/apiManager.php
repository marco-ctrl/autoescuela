<?php

use App\Http\Controllers\PDF\Manager\ComprobanteEgresosController;
use App\Http\Controllers\PDF\Manager\CronogramaResumenController;
use App\Http\Controllers\PDF\Manager\ExportarComprobanteController;
use App\Http\Controllers\PDF\Manager\ReporteGeneralController;
use App\Http\Controllers\PDF\Manager\ReporteMatriculaController;
use App\Http\Controllers\PDF\Manager\ResumenIngresosEgresosController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::prefix('filtrar_manager')->group(function(){
        Route::post('/reporte-general', [ReporteGeneralController::class, 'index']);
        Route::post('/resumen-ingresos-egresos', [ResumenIngresosEgresosController::class, 'index']);
        Route::post('/cronograma-resumen', [CronogramaResumenController::class, 'index']);
        Route::post('/reporte-matriculados', [ReporteMatriculaController::class, 'index']);
    });
});

Route::prefix('manager')->group(function(){
    Route::post('/resumen-ingresos-egresos', [ResumenIngresosEgresosController::class, 'generarPdf'])->name('manager.pdf.resumen-ingresos-egresos');
    Route::post('/cronograma-resumen', [CronogramaResumenController::class, 'generarPdf'])->name('manager.pdf.cronograma-resumen');
    Route::post('/manager/resumen-ingresos-egresos', [ResumenIngresosEgresosController::class, 'generarPdf'])->name('manager.pdf.resumen-ingresos-egresos');
    Route::post('/exportar-comprobante', [ExportarComprobanteController::class, 'generarPdf'])->name('manager.pdf.exportar-comprobante');
    Route::get('/comprobante/{comprobante}/{user}', [ExportarComprobanteController::class, 'generarComprobantePdf']);
    Route::get('/comprobante-ticket/{comprobante}/{user}/{height}', [ExportarComprobanteController::class, 'generarComprobanteTicketPdf']);
    Route::get('/comprobante-render/{comprobante}/{user}', [ExportarComprobanteController::class, 'render']);
    Route::get('/comprobante-egreso/{comprobante}/{user}', [ComprobanteEgresosController::class, 'generarComprobantePdf']);
    Route::get('/comprobante-egreso-ticket/{comprobante}/{user}/{height}', [ComprobanteEgresosController::class, 'generarComprobanteTicketPdf']);
    Route::get('/comprobante-egreso-render/{comprobante}/{user}', [ComprobanteEgresosController::class, 'render']);

    Route::post('/reporte-matriculados', [ReporteMatriculaController::class, 'generarPdf'])->name('manager.pdf.reporte-matriculados');
});
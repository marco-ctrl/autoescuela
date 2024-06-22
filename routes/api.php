<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PDF\Admin\ComprobanteEgresosController;
use App\Http\Controllers\PDF\Admin\CronogramaResumenController;
use App\Http\Controllers\PDF\Admin\ExportarComprobanteController;
use App\Http\Controllers\PDF\Admin\ReporteGeneralController as AdminReporteGeneralController;
use App\Http\Controllers\PDF\Admin\ReporteMatriculaController;
use App\Http\Controllers\PDF\Admin\ResumenIngresosEgresosController;
use App\Http\Controllers\PDF\Caja\PagarDocenteController;
use App\Http\Controllers\PDF\CredencialesEstudianteController;
use App\Http\Controllers\PDF\DetalleCertificadoController;
use App\Http\Controllers\PDF\Docente\ReporteGeneralController;
use App\Http\Controllers\PDF\KardexController;
use App\Http\Controllers\PDF\Manager\ResumenIngresosEgresosController as ManagerResumenIngresosEgresosController;
use App\Http\Controllers\PDF\MatriculaController;
use App\Http\Controllers\Views\Admin\ReportesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login-user', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logoutUser']);
    Route::prefix('filtrar')->group(function(){
        Route::post('/reporte-general', [AdminReporteGeneralController::class, 'index']);
        Route::post('/resumen-ingresos-egresos', [ResumenIngresosEgresosController::class, 'index']);
        Route::post('/cronograma-resumen', [CronogramaResumenController::class, 'index']);
        Route::post('/reporte-matriculados', [ReporteMatriculaController::class, 'index']);
    });
});

Route::prefix('pdf')->group(function () {
    Route::get('/kardex/{matricula}/{user}', [KardexController::class, 'generarPdfKardex']);
    Route::get('/matricula/{matricula}/{user}/A4', [MatriculaController::class, 'generarPdfMatricula']);
    Route::get('/matricula/{matricula}/{user}/ticket', [MatriculaController::class, 'generarPdfMatriculaTicket']);
    Route::get('/kardes/horario-matricula/{matricula}/{user}', [KardexController::class, 'horarioMatricula'])->name('kardes.horario-matricula');
    Route::get('/render/horario-matricula/{matricula}/{user}/{height}', [KardexController::class, 'horarioMatriculaPdf'])->name('kardes.horario-matricula');
    

    Route::get('/detalle-pago-certificado-antecedentes/{programacion}/{user}', [DetalleCertificadoController::class, 'generarPdf']);
    Route::get('/credenciales-estudiante/{estudiante}/{usuario}', [CredencialesEstudianteController::class, 'generarCredenciales']);
    Route::post('/docente/reporte-general', [ReporteGeneralController::class, 'index'])->name('docente.pdf.reporte-general');
    Route::get('/pago-docente/{pagoDocente}', [PagarDocenteController::class, 'index']);
    Route::get('/pago-docente/{pagoDocente}/ticket', [PagarDocenteController::class, 'ticket']);

    Route::post('/resumen-ingresos-egresos', [ResumenIngresosEgresosController::class, 'generarPdf'])->name('admin.pdf.resumen-ingresos-egresos');
    Route::post('/cronograma-resumen', [CronogramaResumenController::class, 'generarPdf'])->name('admin.pdf.cronograma-resumen');
    Route::post('/manager/resumen-ingresos-egresos', [ManagerResumenIngresosEgresosController::class, 'generarPdf'])->name('manager.pdf.resumen-ingresos-egresos');
    Route::post('/exportar-comprobante', [ExportarComprobanteController::class, 'generarPdf'])->name('admin.pdf.exportar-comprobante');
    Route::get('/comprobante/{comprobante}/{user}', [ExportarComprobanteController::class, 'generarComprobantePdf']);
    Route::get('/comprobante-ticket/{comprobante}/{user}/{height}', [ExportarComprobanteController::class, 'generarComprobanteTicketPdf']);
    Route::get('/comprobante-render/{comprobante}/{user}', [ExportarComprobanteController::class, 'render']);
    Route::get('/comprobante-egreso/{comprobante}/{user}', [ComprobanteEgresosController::class, 'generarComprobantePdf']);
    Route::get('/comprobante-egreso-ticket/{comprobante}/{user}/{height}', [ComprobanteEgresosController::class, 'generarComprobanteTicketPdf']);
    Route::get('/comprobante-egreso-render/{comprobante}/{user}', [ComprobanteEgresosController::class, 'render']);

    Route::post('/reporte-matriculados', [ReporteMatriculaController::class, 'generarPdf'])->name('admin.pdf.reporte-matriculados');
});

Route::post('/set-pdf-height', [ExportarComprobanteController::class, 'setHeight']);


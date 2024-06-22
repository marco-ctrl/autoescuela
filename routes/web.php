<?php

use App\Http\Controllers\Views\Admin\CajaController;
use App\Http\Controllers\Views\Admin\CertificadoAntecedentesController;
use App\Http\Controllers\Views\Admin\EstudianteController;
use App\Http\Controllers\Views\Admin\HomeController;
use App\Http\Controllers\Views\Admin\HorarioMatriculaController;
use App\Http\Controllers\Views\Admin\MatriculaController;
use App\Http\Controllers\Views\Admin\ReportesController;
use App\Http\Controllers\Views\AuthController;
use App\Http\Controllers\Views\Admin\ServicioController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::prefix('admin')->group(function () {

    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/servicios', [ServicioController::class, 'index'])->name('admin.registro.servicios.index');
    Route::get('/servicios/create', [ServicioController::class, 'create'])->name('admin.registro.servicios.create');
    
    //Modulo Matricula
    Route::get('/matricula', [MatriculaController::class, 'index'])->name('admin.matriculas.index');
    Route::get('/matricula/create', [MatriculaController::class, 'create'])->name('admin.matriculas.create');
    Route::get('/horario-matricula/{matricula}', [HorarioMatriculaController::class, 'index'])->name('admin.horario-matricula.index');

    //Modulo Estudiante
    Route::get('/estudiante', [EstudianteController::class, 'index'])->name('admin.estudiante.index');
    Route::get('/estudiante/create', [EstudianteController::class, 'create'])->name('admin.estudiante.create');

    //modulo Caja
    Route::get('/pagos', [CajaController::class, 'pagos'])->name('admin.caja.pagos.create');
    Route::get('/pagar-docente', [CajaController::class, 'pagoDocentes'])->name('admin.caja.pagar-docente.create');
    Route::get('/ingresos', [CajaController::class, 'ingresos'])->name('admin.caja.ingresos.create');
    Route::get('/egresos', [CajaController::class, 'gastos'])->name('admin.caja.egresos');

    //modulo Reportes
    Route::get('/reporte-general', [ReportesController::class, 'reporteGeneral'])->name('admin.reportes.reporte-general');
    Route::get('/resumen-ingresos-egresos', [ReportesController::class, 'resumenIngresosEgresos'])->name('admin.reportes.resumen-ingresos-egresos');
    Route::get('/cronograma-resumen', [ReportesController::class, 'cronogramaResumen'])->name('admin.reportes.cronograma-resumen');
    Route::get('/exportar-comprobante', [ReportesController::class, 'exportarComprobantes'])->name('admin.reportes.exportar-comprobante');
    Route::get('/reporte-matriculados', [ReportesController::class, 'matriculados'])->name('admin.reportes.matriculados');
    Route::get('/historial-estudiante', [ReportesController::class, 'historialEstudiante'])->name('admin.reportes.historial-estudiante');
});

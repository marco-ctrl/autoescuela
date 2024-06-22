<?php

use App\Http\Controllers\PDF\Manager\ResumenIngresosEgresosController;
use App\Http\Controllers\Views\Manager\CertificadoAntecedentesController;
use App\Http\Controllers\Views\Manager\CajaController;
use App\Http\Controllers\Views\Manager\EstudianteController;
use App\Http\Controllers\Views\Manager\HomeController;
use App\Http\Controllers\Views\Manager\HorarioMatriculaController;
use App\Http\Controllers\Views\Manager\MatriculaController;
use App\Http\Controllers\Views\Manager\ReportesController;
use Illuminate\Support\Facades\Route;

Route::get('/home', [HomeController::class, 'index'])->name('manager.home');

    Route::get('/certificado-antecedentes-penales', [CertificadoAntecedentesController::class, 'index'])->name('manager.certificado-antecedentes-penales.index');

    //Modulo Matricula
    Route::get('/matricula', [MatriculaController::class, 'index'])->name('manager.matriculas.index');
    Route::get('/matricula/create', [MatriculaController::class, 'create'])->name('manager.matriculas.create');
    Route::get('/horario-matricula/{matricula}', [HorarioMatriculaController::class, 'index'])->name('manager.horario-matricula.index');

    //Modulo Estudiante
    Route::get('/estudiante', [EstudianteController::class, 'index'])->name('manager.estudiante.index');
    Route::get('/estudiante/create', [EstudianteController::class, 'create'])->name('manager.estudiante.create');

    //modulo Caja
    Route::get('/pagos', [CajaController::class, 'pagos'])->name('manager.caja.pagos.create');
    Route::get('/pagar-docente', [CajaController::class, 'pagoDocentes'])->name('manager.caja.pagar-docente.create');
    Route::get('/ingresos', [CajaController::class, 'ingresos'])->name('manager.caja.ingresos.create');
    Route::get('/egresos', [CajaController::class, 'gastos'])->name('manager.caja.egresos');

    //modulo Reportes
    Route::get('/reporte-general', [ReportesController::class, 'reporteGeneral'])->name('manager.reportes.reporte-general');
    Route::get('/resumen-ingresos-egresos', [ReportesController::class, 'resumenIngresosEgresos'])->name('manager.reportes.resumen-ingresos-egresos');
    Route::get('/cronograma-resumen', [ReportesController::class, 'cronogramaResumen'])->name('manager.reportes.cronograma-resumen');
    Route::get('/exportar-comprobante', [ReportesController::class, 'exportarComprobantes'])->name('manager.reportes.exportar-comprobante');
    Route::get('/reporte-matriculados', [ReportesController::class, 'matriculados'])->name('manager.reportes.matriculados');
    Route::get('/historial-estudiante', [ReportesController::class, 'historialEstudiante'])->name('manager.reportes.historial-estudiante');
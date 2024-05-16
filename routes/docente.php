<?php

use App\Http\Controllers\Views\Docente\AsistenciaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Views\Docente\HomeController;

Route::get('/home', [HomeController::class, 'index'])->name('docente.home');
Route::get('/asistencia', [AsistenciaController::class, 'index'])->name('docente.asistencia');
Route::get('reporte-general', function(){ return view('docente.reportes.reporteGeneral'); })->name(('docente.reporte-general'));
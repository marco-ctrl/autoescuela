<?php

use App\Http\Controllers\Views\Admin\EstudianteController;
use App\Http\Controllers\Views\Admin\HomeController;
use App\Http\Controllers\Views\Admin\HorarioMatriculaController;
use App\Http\Controllers\Views\Admin\MatriculaController;
use App\Http\Controllers\Views\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::prefix('admin')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/matricula', [MatriculaController::class, 'index'])->name('admin.matriculas.index');
    Route::get('/matricula/create', [MatriculaController::class, 'create'])->name('admin.matriculas.create');
    Route::get('/horario-matricula/{matricula}', [HorarioMatriculaController::class, 'index'])->name('admin.horario-matricula.index');

    Route::get('/estudiante', [EstudianteController::class, 'index'])->name('admin.estudiante.index');
    Route::get('/estudiante/create', [EstudianteController::class, 'create'])->name('admin.estudiante.create');
});

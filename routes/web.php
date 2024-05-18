<?php

use App\Http\Controllers\Views\Admin\CajaController;
use App\Http\Controllers\Views\Admin\EstudianteController;
use App\Http\Controllers\Views\Admin\HomeController;
use App\Http\Controllers\Views\Admin\HorarioMatriculaController;
use App\Http\Controllers\Views\Admin\MatriculaController;
use App\Http\Controllers\Views\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::prefix('admin')->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('admin.home');
    Route::get('/matricula', [MatriculaController::class, 'index'])->name('admin.matriculas.index');
    Route::get('/matricula/create', [MatriculaController::class, 'create'])->name('admin.matriculas.create');
    Route::get('/horario-matricula/{matricula}', [HorarioMatriculaController::class, 'index'])->name('admin.horario-matricula.index');

    Route::get('/estudiante', [EstudianteController::class, 'index'])->name('admin.estudiante.index');
    Route::get('/estudiante/create', [EstudianteController::class, 'create'])->name('admin.estudiante.create');

    Route::get('/pagos', [CajaController::class, 'pagos'])->name('admin.caja.pagos.create');
    Route::get('/pagar-docente', [CajaController::class, 'pagoDocentes'])->name('admin.caja.pagar-docente.create');
    Route::get('/ingresos', [CajaController::class, 'ingresos'])->name('admin.caja.ingresos.create');
});

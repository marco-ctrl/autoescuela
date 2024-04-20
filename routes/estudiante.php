<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Views\Estudiante\HomeController;
use App\Http\Controllers\Views\Estudiante\HorarioController;

Route::get('/home', [HomeController::class, 'index'])->name('estudiante.home');
Route::get('/horario', [HorarioController::class, 'index'])->name('estudiante.horario');
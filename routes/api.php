<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\PDF\CredencialesEstudianteController;
use App\Http\Controllers\PDF\Docente\ReporteGeneralController;
use App\Http\Controllers\PDF\KardexController;
use App\Http\Controllers\PDF\MatriculaController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/login-user', [AuthController::class, 'loginUser']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('/logout', [AuthController::class, 'logoutUser']);
});

Route::prefix('pdf')->group(function () {
    Route::get('/kardex/{matricula}/{user}', [KardexController::class, 'generarPdfKardex']);
    Route::get('/matricula/{matricula}/{user}/A4', [MatriculaController::class, 'generarPdfMatricula']);
    Route::get('/matricula/{matricula}/{user}/ticket', [MatriculaController::class, 'generarPdfMatriculaTicket']);

    Route::get('/credenciales-estudiante/{estudiante}/{usuario}', [CredencialesEstudianteController::class, 'generarCredenciales']);
    Route::post('/docente/reporte-general', [ReporteGeneralController::class, 'index'])->name('docente.pdf.reporte-general');
    //Route::get('/docente/reporte-general', [ReporteGeneralController::class, 'index']);

});

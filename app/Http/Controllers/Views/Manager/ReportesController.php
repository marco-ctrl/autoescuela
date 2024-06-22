<?php

namespace App\Http\Controllers\Views\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function reporteGeneral(){
        return view('manager.reportes.reporte-general');
    }

    public function resumenIngresosEgresos()
    {
        return view('manager.reportes.resumen-ingresos-egresos');
    }

    public function cronogramaResumen()
    {
        return view('manager.reportes.cronograma-resumen');
    }

    public function exportarComprobantes()
    {
        return view('manager.reportes.exportar-comprobante');
    }

    public function matriculados()
    {
        return view('manager.reportes.reporte-matriculados');
    }

    public function historialEstudiante()
    {
        return view('manager.reportes.historial-estudiante');
    }
}

<?php

namespace App\Http\Controllers\Views\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportesController extends Controller
{
    public function reporteGeneral(){
        return view('admin.reportes.reporte-general');
    }

    public function resumenIngresosEgresos()
    {
        return view('admin.reportes.resumen-ingresos-egresos');
    }

    public function cronogramaResumen()
    {
        return view('admin.reportes.cronograma-resumen');
    }

    public function exportarComprobantes()
    {
        return view('admin.reportes.exportar-comprobante');
    }

    public function matriculados()
    {
        return view('admin.reportes.reporte-matriculados');
    }

    public function historialEstudiante()
    {
        return view('admin.reportes.historial-estudiante');
    }
}

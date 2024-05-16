<?php

namespace App\Http\Controllers\PDF\Docente;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use App\Models\ItInstitucion;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteGeneralController extends Controller
{
    
    public function index(Request $request)
    {
        $datos = json_decode($request->datos);

        $institucion = ItInstitucion::first();
        $docente = ItDocente::where('us_codigo', $request->usuario);

        $pdf = Pdf::setPaper('letter', 'landscape')
        ->loadView('pdf.docente.reporteGeneral', compact('datos', 'institucion', 'docente'));
        
        return $pdf->stream('reporte_general.pdf');
    }
}

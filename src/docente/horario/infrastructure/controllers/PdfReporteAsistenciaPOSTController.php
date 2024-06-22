<?php

namespace Src\docente\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use App\Models\ItHorarioMatricula;
use App\Models\ItInstitucion;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Src\docente\horario\infrastructure\resources\ListHorarioAsistenciaResource;

final class PdfReporteAsistenciaPOSTController extends Controller
{

    public function index(Request $request)
    {
        $docente = ItDocente::where('us_codigo', $request->usuario)->first();
        $cronogramas = ItHorarioMatricula::with('docente', 'matricula.estudiante')
            ->where('do_codigo', $docente->do_codigo)
            ->whereDate('hm_fecha_inicio', '>=', $request->fechaInicial)
            ->whereDate('hm_fecha_inicio', '<=', $request->fechaFinal)
            ->get();
        $cronogramasResource = ListHorarioAsistenciaResource::collection($cronogramas);
        $cronogramas = $cronogramasResource->toArray($request);

        $institucion = ItInstitucion::first();

        $usuario = User::find($request->usuario);
        $pdf = Pdf::setPaper('legal', 'landscape')
            ->loadView('pdf.reporte-asistencia',
                compact('cronogramas', 'institucion',
                    'usuario'));
        return $pdf->stream('cronograma_resumen.pdf');
    }
}

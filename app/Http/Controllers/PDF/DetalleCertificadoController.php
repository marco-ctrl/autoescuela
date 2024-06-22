<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\ItHorarioMatricula;
use App\Models\ItInstitucion;
use App\Models\ItMatricula;
use App\Models\ItProgramacion;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Src\admin\certificado_antecedentes\infrastructure\resources\ListPagoCuotaResource;
use Src\admin\horario\infrastructure\resources\ListHorarioMatriculaResource;
use Src\admin\matricula\infrastructure\resources\ListAllMatriculaResource;
use Symfony\Component\HttpFoundation\Response;

class DetalleCertificadoController extends Controller
{
    public function generarPdf(ItProgramacion $programacion, User $user, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();

        if (!$token) {
            return Response::HTTP_UNAUTHORIZED;
        }
        $usuario = User::find($token->tokenable_id);

        $programaciones = ItProgramacion::find($programacion->pg_codigo);
        $programacioData = new ListPagoCuotaResource($programacion);
        $programacion = $programacioData->toArray($request);

        $cuotas = $programaciones->cuota;

        $institucion = ItInstitucion::first();

        $pdf = Pdf::setPaper('A4', 'portrait')
        ->loadView('pdf.detalle-certificado',
            compact( 'usuario', 'programacion', 'cuotas', 'institucion')
        );
        return $pdf->stream('certificado_antecedentes' . $programaciones->pg_codigo . '.pdf');
    }

}

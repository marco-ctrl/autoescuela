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
use Src\admin\horario\infrastructure\resources\ListHorarioMatriculaResource;
use Src\admin\matricula\infrastructure\resources\ListAllMatriculaResource;

class MatriculaController extends Controller
{
    public function generarPdfMatricula(ItMatricula $matricula, User $user, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();

        if (!$token) {
            return redirect()->route('login');
        }
        $usuario = User::find($token->tokenable_id);

        $matriculaData = new ListAllMatriculaResource($matricula);
        $matriculas = $matriculaData->toArray($request);

        $programacion = ItProgramacion::with('cuota.pagoCuota.usuario.trabajador')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->first();

        $cuotas = $programacion->cuota;

        $horarioMatricula = ItHorarioMatricula::with('docente')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->get();

        $horariosData = ListHorarioMatriculaResource::collection($horarioMatricula);
        $horarios = $horariosData->toArray($request);

        $institucion = ItInstitucion::first();

        $pdf = Pdf::setPaper('A4', 'portrait')
        ->loadView('pdf.matricula',
            compact( 'usuario', 'matriculas', 'cuotas', 'institucion')
        );
        return $pdf->download('matricula' . $matricula->ma_codigo . '.pdf');
    }

    public function generarPdfMatriculaTicket(ItMatricula $matricula, User $user, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();

        if (!$token) {
            return redirect()->route('login');
        }
        $usuario = User::find($token->tokenable_id);

        $data = [
            'title' => 'Matricula PDF',
            'date' => date('m/d/Y'),
            'time' => date('h:i:s A'),
        ];

        $matriculaData = new ListAllMatriculaResource($matricula);
        $matriculas = $matriculaData->toArray($request);

        $programacion = ItProgramacion::with('cuota.pagoCuota.usuario.trabajador')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->first();

        $cuotas = $programacion->cuota;

        $horarioMatricula = ItHorarioMatricula::with('docente')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->get();

        $horariosData = ListHorarioMatriculaResource::collection($horarioMatricula);
        $horarios = $horariosData->toArray($request);

        $institucion = ItInstitucion::first();

        $pdf = Pdf::setPaper([35,0,226.772456,1210], 'portrait');
        $pdf->setOption(['margin_left' => 0]);
        $pdf->loadView('pdf.matriculaTicket',
            compact('data', 'usuario', 'matriculas', 'cuotas', 'institucion')
        );
        
        return $pdf->download('matricula' . $matricula->ma_codigo . '.pdf');
    }
}

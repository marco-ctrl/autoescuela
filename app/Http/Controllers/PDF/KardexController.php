<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\ItHorarioMatricula;
use App\Models\ItMatricula;
use App\Models\ItProgramacion;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Src\admin\horario\infrastructure\resources\ListHorarioMatriculaResource;
use Src\admin\matricula\infrastructure\resources\ListAllMatriculaResource;

class KardexController extends Controller
{
    public function generarPdfKardex(ItMatricula $matricula, User $user, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();
        $usuario = User::find($token->tokenable_id);
        
        if(!$usuario)
        {
            return redirect()->route('login');
        }
        $data = [
            'title' => 'Autoescuela',
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

        $pdf = PDF::loadView('pdf.kardex', compact('data', 'matriculas', 'cuotas', 'horarios'));
        return $pdf->stream('kardex.pdf');
    }
}

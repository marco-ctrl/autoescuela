<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Http\Resources\PDF\Admin\CronogramaResumenResource;
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
        
        //dd($cuotas[0]->pagoCuota);

        $horarioMatricula = ItHorarioMatricula::with('docente')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->orderBy('hm_fecha_inicio', 'asc')
            ->get();

        $horariosData = ListHorarioMatriculaResource::collection($horarioMatricula);
        $horarios = $horariosData->toArray($request);

        $pdf = PDF::loadView('pdf.kardex', compact('data', 'matriculas', 'cuotas', 'horarios'));
        return $pdf->stream('kardex.pdf');
    }
    
    public function horarioMatricula(ItMatricula $matricula, User $user, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();
        $usuario = User::find($token->tokenable_id);

        if (!$usuario) {
            return redirect()->route('login');
        }
        $data = [
            'title' => 'Autoescuela',
            'date' => date('m/d/Y'),
            'time' => date('h:i:s A'),
        ];

        $matricula = ItMatricula::find($matricula->ma_codigo);
        $matriculaData = new ListAllMatriculaResource($matricula);
        $matriculas = $matriculaData->toArray($request);

        $programacion = ItProgramacion::with('cuota.pagoCuota.usuario.trabajador')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->first();

        $cuotas = $programacion->cuota;

        $horarioMatricula = ItHorarioMatricula::with('docente')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->orderBy('hm_fecha_inicio', 'asc')
            ->get();

        $horariosData = CronogramaResumenResource::collection($horarioMatricula);
        $horarios = $horariosData->toArray($request);

        $institucion = ItInstitucion::first();

        return view('pdf.kardex-horario-matricula', compact('usuario', 'institucion', 'data', 'matriculas', 'cuotas', 'horarios'));
    }

    public function horarioMatriculaPdf(ItMatricula $matricula, User $user, float $height, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();
        $usuario = User::find($token->tokenable_id);

        if (!$usuario) {
            return redirect()->route('login');
        }
        $data = [
            'title' => 'Autoescuela',
            'date' => date('m/d/Y'),
            'time' => date('h:i:s A'),
        ];

        $matricula = ItMatricula::find($matricula->ma_codigo);
        $matriculaData = new ListAllMatriculaResource($matricula);
        $matriculas = $matriculaData->toArray($request);

        $programacion = ItProgramacion::with('cuota.pagoCuota.usuario.trabajador')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->first();

        $cuotas = $programacion->cuota;

        $horarioMatricula = ItHorarioMatricula::with('docente')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->orderBy('hm_fecha_inicio', 'asc')
            ->get();

        $horariosData = CronogramaResumenResource::collection($horarioMatricula);
        $horarios = $horariosData->toArray($request);

        $institucion = ItInstitucion::first();

        $height = $height * 3.3;

        $pdf = Pdf::setPaper([0, 0, 226.772, $height], 'portrait')
            ->loadView('pdf.kardex-horario-matricula', compact('institucion',
                'data',
                'matriculas',
                'cuotas',
                'horarios',
                'usuario'));
        return $pdf->stream('horario-matricula.pdf');
        //return view('pdf.kardex-horario-matricula', compact('institucion', 'data', 'matriculas', 'cuotas', 'horarios'));
    }
}

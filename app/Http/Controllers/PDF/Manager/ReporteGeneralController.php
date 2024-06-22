<?php

namespace App\Http\Controllers\PDF\Manager;

use App\Http\Controllers\Controller;
use App\Models\ItHorarioMatricula;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Http\Request;
use Src\docente\horario\infrastructure\resources\ListHorarioGeneralResource;
use Symfony\Component\HttpFoundation\Response;

class ReporteGeneralController extends Controller
{
    public function index(Request $request){
        try {
            $horarioGeneral = ItHorarioMatricula::with('docente', 'matricula.estudiante')
                ->whereDate('hm_fecha_inicio', $request->fecha)
                ->where('do_codigo', $request->codigo)
                ->orderBy('hm_fecha_inicio', 'asc')
                ->get();

            if($horarioGeneral->count() == 0){
                return response()->json([
                    'status' => false,
                    'message' => 'No se encontraron horarios para la fecha seleccionada',
                ], Response::HTTP_OK);
            }

            return response()->json([
                'status' => true,
                'data' => ListHorarioGeneralResource::collection($horarioGeneral),
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to list horarios asistencia'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

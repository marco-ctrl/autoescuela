<?php

namespace Src\docente\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use App\Models\ItHorarioMatricula;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\docente\horario\infrastructure\resources\ListHorarioGeneralResource;
use Symfony\Component\HttpFoundation\Response;

final class ListHorarioGeneralPOSTController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        try {
            $docente = ItDocente::where('us_codigo', $request->codigo)->first();

            $horarioGeneral = ItHorarioMatricula::with('docente', 'matricula.estudiante')
                ->whereDate('hm_fecha_inicio', $request->fecha)
                ->where('do_codigo', $docente->do_codigo)
                ->orderBy('hm_fecha_inicio', 'asc')
                ->get();

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

<?php

namespace Src\docente\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use App\Models\ItHorarioMatricula;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\docente\horario\infrastructure\resources\ListHorarioAsistenciaResource;
use Symfony\Component\HttpFoundation\Response;

final class ListHorarioAsistenciaGETController extends Controller { 

 public function index(User $usuario, Request $request): JsonResponse { 
    try {
        $docente = ItDocente::where('us_codigo', $usuario->us_codigo)->first();
        $horarioAsistencia = ItHorarioMatricula::with('docente', 'matricula.estudiante')
            ->where('do_codigo', $docente->do_codigo)
            ->get();

        return response()->json([
            'status' => true,
            'data' => ListHorarioAsistenciaResource::collection($horarioAsistencia),
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
<?php

namespace Src\app\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItEstudiante;
use App\Models\ItHorarioMatricula;
use App\Models\ItMatricula;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Src\app\horario\infrastructure\resources\ListHorarioResource;
use Symfony\Component\HttpFoundation\Response;

final class ListHorarioGETController extends Controller { 

 public function index(User $usuario): JsonResponse { 
    try {
        $estudiante = ItEstudiante::where('us_codigo', $usuario->us_codigo)->first();
        $matricula = ItMatricula::where('es_codigo', $estudiante->es_codigo)->first();
        
        
        $horarioAsistencia = ItHorarioMatricula::with('docente', 'matricula.estudiante')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->get();

        return response()->json([
            'status' => true,
            'data' => ListHorarioResource::collection($horarioAsistencia),
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
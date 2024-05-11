<?php

namespace Src\admin\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItHorarioMatricula;
use App\Models\ItMatricula;
use Illuminate\Http\JsonResponse;
use Src\admin\horario\infrastructure\resources\ListHorarioMatriculaResource;
use Symfony\Component\HttpFoundation\Response;

final class ListHorarioMatriculaGETController extends Controller { 

 public function index(ItMatricula $matricula): JsonResponse { 
    try {
        $horarioMatriculas = ItHorarioMatricula::with('docente')
            ->where('ma_codigo', $matricula->ma_codigo)
            ->orderBy('hm_fecha_inicio', 'asc')
            ->get();

        return response()->json([
            'status' => true,
            'data' => ListHorarioMatriculaResource::collection($horarioMatriculas),
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list horarios'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
 }
}
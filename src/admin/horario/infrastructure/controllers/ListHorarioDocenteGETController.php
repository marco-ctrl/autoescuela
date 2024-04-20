<?php

namespace Src\admin\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use App\Models\ItHorarioMatricula;
use Illuminate\Http\JsonResponse;
use Src\admin\horario\infrastructure\resources\ListHorarioDocenteResource;
use Symfony\Component\HttpFoundation\Response;

final class ListHorarioDocenteGETController extends Controller { 

 public function index(ItDocente $docente): JsonResponse { 
    try {
        $horarioDocentes = ItHorarioMatricula::with('docente')
            ->where('do_codigo', $docente->do_codigo)
            ->get();

        return response()->json([
            'status' => true,
            'data' => ListHorarioDocenteResource::collection($horarioDocentes),
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
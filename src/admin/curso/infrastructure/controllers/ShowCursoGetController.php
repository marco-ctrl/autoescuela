<?php

namespace Src\admin\curso\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItCurso;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ShowCursoGETController extends Controller { 

 public function index(ItCurso $curso):JsonResponse { 
    try {
        $cursos = ItCurso::find($curso->cu_codigo);

        return response()->json([
            'status' => true,
            'data' => $cursos,
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list cursos'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
 }
}
<?php

namespace Src\admin\curso\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItCurso;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\admin\curso\infrastructure\resources\AutoCompleteCursoResource;
use Symfony\Component\HttpFoundation\Response;

final class AutoCompleteCursoGETController extends Controller { 

 public function index(Request $request):JsonResponse { 
    try {
        $term = $request->input('term');

        $cursos = ItCurso::where('cu_descripcion', 'LIKE', '%' . $term . '%')
            ->orWhere('cu_costo', 'LIKE', '%' . $term . '%')
            ->orWhere('cu_duracion', 'LIKE', '%' . $term . '%')
            ->latest('cu_codigo')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => true,
            'data' => $cursos = AutoCompleteCursoResource::collection($cursos),
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
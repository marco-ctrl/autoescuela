<?php

namespace Src\admin\estudiante\infrastructure\controllers;

use App\Http\Controllers\Controller;
use Src\admin\estudiante\infrastructure\resources\AutoCompleteEstudianteResource;
use App\Models\ItEstudiante;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class AutoCompleteEstudianteGETController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        try {
            $term = $request->input('term');
            $estudiante = ItEstudiante::query()
                ->whereAny(
                    ['es_nombre', 'es_apellido', 'es_documento'], 
                    'LIKE', '%' . $term . '%'
                )->limit(5)->get();

            return response()->json([
                'status' => true,
                'data' => $estudiante = AutoCompleteEstudianteResource::collection($estudiante),
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to search estudiantes'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}

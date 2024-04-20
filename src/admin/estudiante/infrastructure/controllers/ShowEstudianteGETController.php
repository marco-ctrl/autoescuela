<?php

namespace Src\admin\estudiante\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItEstudiante;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\admin\estudiante\infrastructure\resources\ListAllEstudianteResource;
use Symfony\Component\HttpFoundation\Response;

final class ShowEstudianteGETController extends Controller
{

    public function index(ItEstudiante $estudiante): JsonResponse
    {
        try {
            $estudiante = ItEstudiante::find($estudiante->es_codigo);
                
            return response()->json([
                'status' => true,
                'data' => new ListAllEstudianteResource($estudiante),
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

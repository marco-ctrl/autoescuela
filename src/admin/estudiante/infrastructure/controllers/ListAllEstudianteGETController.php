<?php

namespace Src\admin\estudiante\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\EstudianteResource;
use App\Models\ItEstudiante;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\admin\estudiante\infrastructure\resources\ListAllEstudianteResource;
use Symfony\Component\HttpFoundation\Response;

final class ListAllEstudianteGETController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        try {
            $term = $request->input('term');
            $estudiante = ItEstudiante::query()
                ->whereAny(
                    ['es_nombre', 'es_apellido', 'es_documento'], 
                    'LIKE', '%' . $term . '%'
                )
                ->orderBy('es_codigo', 'Desc')
                ->paginate(10);
            
            $paginationData = $estudiante->toArray();
            $pagination = [
                'current_page' => $paginationData['current_page'],
                'total' => $paginationData['total'],
                'per_page' => $paginationData['per_page'],
                'last_page' => $paginationData['last_page'],
                'next_page_url' => $paginationData['next_page_url'],
                'prev_page_url' => $paginationData['prev_page_url'],
                'from' => $paginationData['from'],
                'to' => $paginationData['to'],
                'links' => $paginationData['links'],
            ];

            return response()->json([
                'status' => true,
                'data' => $estudiante = ListAllEstudianteResource::collection($estudiante),
                'pagination' => $pagination,
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

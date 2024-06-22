<?php

namespace Src\manager\estudiante\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItEstudiante;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\manager\estudiante\infrastructure\resources\ListAllEstudianteResource;
use Symfony\Component\HttpFoundation\Response;

final class ListAllEstudianteGETController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        try {
            $term = strtoupper($request->input('term'));
            $estudiante = ItEstudiante::query()
                ->where(function ($query) use ($term) {
                    $query->where('es_nombre', 'LIKE', '%' . $term . '%')
                        ->orWhere('es_apellido', 'LIKE', '%' . $term . '%')
                        ->orWhere('es_documento', 'LIKE', '%' . $term . '%')
                        ->orWhere(DB::raw("CONCAT(es_nombre, ' ', es_apellido)"), 'LIKE', '%' . $term . '%');
                })
                ->where('us_codigo_create', auth()->user()->us_codigo)
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

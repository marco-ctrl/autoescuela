<?php

namespace Src\admin\pago_cuota\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItMatricula;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\admin\pago_cuota\infrastructure\resources\ListPagoCuotaResource;
use Symfony\Component\HttpFoundation\Response;

final class ListPagoCuotaGETController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        try {
            $term = $request->input('term'); // Asumiendo que el término de búsqueda se obtiene del request

            $matriculas = ItMatricula::with('usuario.trabajador', 'estudiante')
                ->join('it_estudiante', 'it_matricula.es_codigo', '=', 'it_estudiante.es_codigo')
                ->where(function ($query) use ($term) {
                    $query->where('it_estudiante.es_nombre', 'LIKE', '%' . $term . '%')
                        ->orWhere('it_estudiante.es_apellido', 'LIKE', '%' . $term . '%')
                        ->orWhere('it_estudiante.es_documento', 'LIKE', '%' . $term . '%')
                        ->orWhere(DB::raw("CONCAT(TRIM(it_estudiante.es_nombre), ' ', TRIM(it_estudiante.es_apellido))"), 'LIKE', '%' . $term . '%');
                })
                ->orderBy('it_matricula.ma_codigo', 'desc')
                ->paginate(8, ['it_matricula.*']); // Asegurarse de seleccionar los campos correctos de la tabla principal

            $matriculas->load('usuario.trabajador', 'estudiante');
            
            $matriculasResource = ListPagoCuotaResource::collection($matriculas);

            $paginationData = $matriculas->toArray();

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
                'data' => $matriculasResource,
                'pagination' => $pagination,
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

<?php

namespace Src\manager\certificado_antecedentes\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItProgramacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\manager\certificado_antecedentes\infrastructure\resources\ListPagoCuotaResource;
use Symfony\Component\HttpFoundation\Response;

final class ListAllCertificadoAntecedentesGETController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        try{
            $term = $request->input('term'); // Asumiendo que el término de búsqueda se obtiene del request

            $certificados = ItProgramacion::with('usuario.trabajador', 'estudiante')
                ->join('it_estudiante', 'it_programacion.es_codigo', '=', 'it_estudiante.es_codigo')
                ->where(function ($query) use ($term) {
                    $query->where('it_estudiante.es_nombre', 'LIKE', '%' . $term . '%')
                        ->orWhere('it_estudiante.es_apellido', 'LIKE', '%' . $term . '%')
                        ->orWhere('it_estudiante.es_documento', 'LIKE', '%' . $term . '%')
                        ->orWhere(DB::raw("CONCAT(TRIM(it_estudiante.es_nombre), ' ', TRIM(it_estudiante.es_apellido))"), 'LIKE', '%' . $term . '%');
                })
                ->where('ca_codigo', '<>', null)
                //->where('it_programacion.us_codigo', auth()->user()->us_codigo)
                ->orderBy('it_programacion.pg_codigo', 'desc')
                ->paginate(8, ['it_programacion.*']); // Asegurarse de seleccionar los campos correctos de la tabla principal

            $certificados->load('usuario.trabajador', 'estudiante');
            
            $certificadoResource = ListPagoCuotaResource::collection($certificados);

            $paginationData = $certificados->toArray();

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

            //$certificado = ItProgramacion::where('ca_codigo', '<>', null)->get();

            return response()->json([
                'status' => true,
                'data' => $certificadoResource,
                'pagination' => $pagination,
            ], Response::HTTP_OK);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'error al listar Certifiaco de antecedentes',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

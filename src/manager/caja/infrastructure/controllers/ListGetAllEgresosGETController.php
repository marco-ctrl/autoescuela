<?php

namespace Src\manager\caja\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\manager\caja\infrastructure\resources\ListGetAllEgresosGETResources;
use Symfony\Component\HttpFoundation\Response;

final class ListGetAllEgresosGETController extends Controller
{

    public function index(Request $request): JsonResponse
    {
        try {
            $term = $request->input('term');
            $egresos = ItComprobantePago::where('cp_tipo', 3)
                ->where('cp_informacion', 'LIKE', '%' . $term . '%')
                ->where('us_codigo', auth()->user()->us_codigo)
                ->orderBy('cp_fecha_cobro', 'desc')
                ->paginate(10);

            $paginationData = $egresos->toArray();
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

            //dd($egresos);
            return response()->json([
                'status' => true,
                'data' => ListGetAllEgresosGETResources::collection($egresos),
                'pagination' => $pagination,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al cargar los egresos',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

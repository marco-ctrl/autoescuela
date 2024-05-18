<?php

namespace Src\admin\caja\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use Illuminate\Http\JsonResponse;
use Src\admin\caja\infrastructure\resources\ListGetAllIngresosGETResources;
use Symfony\Component\HttpFoundation\Response;

final class ListGetAllIngresosGETController extends Controller { 

 public function index(): JsonResponse { 
    try{
        $ingresos = ItComprobantePago::where('cp_tipo', 1)
         ->orWhere('cp_tipo', 2)
         ->orderBy('cp_fecha_cobro', 'desc')
         ->paginate(10);

         $paginationData = $ingresos->toArray();
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
            'data' => ListGetAllIngresosGETResources::collection($ingresos),
            'pagination' => $pagination,
        ], Response::HTTP_OK);
    }
    catch(\Exception $e){
        return response()->json([
            'status' => false,
            'message' => 'Error al cargar los ingresos',
            'error' => $e->getMessage()
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
 }
}
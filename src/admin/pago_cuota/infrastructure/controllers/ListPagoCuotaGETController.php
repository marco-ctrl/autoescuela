<?php

namespace Src\admin\pago_cuota\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItMatricula;
use Illuminate\Http\JsonResponse;
use Src\admin\pago_cuota\infrastructure\resources\ListPagoCuotaResource;
use Symfony\Component\HttpFoundation\Response;

final class ListPagoCuotaGETController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $matriculas = ItMatricula::with('usuario.trabajador')
            ->orderBy('ma_codigo', 'desc')
            ->paginate(8);
            
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

<?php

namespace Src\manager\comprobante\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItComprobante;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListAllComprobanteGETController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $comprobante = ItComprobante::where('cb_estado', 1)->get();

            return response()->json([
                'status' => true,
                'data' => $comprobante,
                'message' => 'Listado de comprobantes',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error al obtener los comprobantes' + $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        
        }
    }
}

<?php

namespace Src\admin\categoria\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItCategoriaAmbiente;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListAllCategoriaGETController extends Controller { 

 public function index(int $edad): JsonResponse { 
    try {
        $categoria = ItCategoriaAmbiente::where('ca_edad', '<=', $edad)->get();

        return response()->json([
            'status' => true,
            'data' => $categoria,
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list categorias'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

 }
}
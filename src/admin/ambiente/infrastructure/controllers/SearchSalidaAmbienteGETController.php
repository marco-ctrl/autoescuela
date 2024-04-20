<?php

namespace Src\admin\ambiente\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItAmbiente;
use App\Models\ItPabellon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class SearchSalidaAmbienteGETController extends Controller { 

 public function index(ItPabellon $salida): JsonResponse { 
    try {
        $ambiente = ItAmbiente::where('pa_codigo', $salida->pa_codigo)->get();

        return response()->json([
            'status' => true,
            'data' => $ambiente,
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list ambiente'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

 }
}
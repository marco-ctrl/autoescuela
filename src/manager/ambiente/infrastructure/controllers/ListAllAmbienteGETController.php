<?php

namespace Src\manager\ambiente\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItAmbiente;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListAllAmbienteGETController extends Controller { 

 public function index(): JsonResponse { 
    try {
        $ambiente = ItAmbiente::all();

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
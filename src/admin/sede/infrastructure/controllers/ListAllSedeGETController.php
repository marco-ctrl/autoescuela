<?php

namespace Src\admin\sede\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItSede;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListAllSedeGETController extends Controller { 

 public function index(): JsonResponse { 
    try {
        $sede = ItSede::all();

        return response()->json([
            'status' => true,
            'data' => $sede,
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list sede'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }

 }
}
<?php

namespace Src\admin\salida\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItPabellon;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListAllSalidaGETController extends Controller
{

    public function index(): JsonResponse
    {
        try {

            return response()->json([
                'status' => true,
                'data' => ItPabellon::all(),
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to list salidas'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

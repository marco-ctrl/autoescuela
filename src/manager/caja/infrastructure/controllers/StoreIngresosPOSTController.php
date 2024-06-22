<?php

namespace Src\manager\caja\infrastructure\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\manager\caja\infrastructure\validators\StoreIngresosRequest;
use Symfony\Component\HttpFoundation\Response;

final class StoreIngresosPOSTController extends Controller
{
    public function index(StoreIngresosRequest $request): JsonResponse{
        try{
            $data = $request->validated();

            $ingreso = app()->make('Src\manager\caja\application\StoreIngresosService')->run($data);
            
            return response()->json([
                'status' => true,
                'message' => 'Ingreso creado correctamente',
                'data' => $ingreso,
            ], Response::HTTP_CREATED); // Created
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error al crear el ingreso',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR); // Internal Server Error
        }
    }
}
<?php

namespace Src\admin\caja\infrastructure\controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Src\admin\caja\infrastructure\validators\StoreEgresosRequest;
use Symfony\Component\HttpFoundation\Response;

final class StoreEgresosPOSTController extends Controller
{
    public function index(StoreEgresosRequest $request): JsonResponse{
        try{
            $data = $request->validated();

            $egreso = app()->make('Src\admin\caja\application\StoreEgresosService')->run($data);
            
            return response()->json([
                'status' => true,
                'message' => 'Egresos registrado correctamente',
                'data' => $egreso,
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
<?php

namespace Src\manager\servicios\infrastructure\controllers;

use App\Models\ItServicio;
use App\Http\Controllers\Controller;
use Src\manager\servicios\infrastructure\validators\StoreServiciosRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreServiciosPOSTController extends Controller
{
    public function index(StoreServiciosRequest $request)
    {
        try{
            $servicio = new ItServicio();
            $servicio->sv_descripcion = strtoupper($request->descripcion);
            $servicio->sv_precio = $request->precio;
            $servicio->save();

            return response()->json([
                'message' => __('servicio guardado con exito'),
                'status' => true,
                'data' => $servicio
            ], Response::HTTP_OK);
        }
        catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
                'message' => __('error al guardar un servicio'),
                'status' => false,
            ], 500);
        }
    }
}
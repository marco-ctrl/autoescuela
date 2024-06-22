<?php

namespace Src\admin\servicios\infrastructure\controllers;

use App\Models\ItServicio;
use App\Http\Controllers\Controller;
use Src\admin\servicios\infrastructure\validators\UpdateServiciosRequest;
use Symfony\Component\HttpFoundation\Response;

class UpdateServiciosPUTController extends Controller
{
    public function index(ItServicio $servicio, UpdateServiciosRequest $request)
    {
        try{
            //$servicio = new ItServicio();
            $servicio->sv_descripcion = strtoupper($request->descripcion);
            $servicio->sv_precio = $request->precio;
            $servicio->save();

            return response()->json([
                'message' => __('servicio modificado con exito'),
                'status' => true,
                'data' => $servicio
            ], Response::HTTP_OK);
        }
        catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
                'message' => __('error al modificar el servicio'),
                'status' => false,
            ], 500);
        }
    }
}
<?php

namespace Src\admin\servicios\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItServicio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class InhabilitarServicioDELETEController extends Controller
{
    public function index(ItServicio $servicio): JsonResponse{
        try{
            //$servicio->id = $request->id;
            $servicio->sv_estado = 0;
            $servicio->save();
            return response()->json([
                'status' => true,
                'message' => 'Servicio inhabilitado correctamente',
                'data' => $servicio,
            ], Response::HTTP_OK);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'Error al eliminar el servicio',
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
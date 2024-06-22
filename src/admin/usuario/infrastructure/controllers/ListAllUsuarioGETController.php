<?php

namespace Src\admin\usuario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItTrabajador;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListAllUsuarioGETController extends Controller
{

    public function index(): JsonResponse
    {
        try{
            $usuarios = ItTrabajador::with('usuario')->get();
            return response()->json([
                'status' => true,
                'message' => 'lista de usuarios',
                'data' => $usuarios
            ], Response::HTTP_OK);
        }
        catch(\Exception $e){
            return response()->json([
                'status' => false,
                'message' => 'error al listar usuarios',
                'error' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace Src\docente\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use App\Models\ItHorarioMatricula;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class CantidadClasesMesGETController extends Controller { 

 public function index(User $usuario): JsonResponse { 
    try {
        if($usuario->us_codigo != auth()->user()->us_codigo){
            return response()->json([
                'status' => true,
                'message' => 'usuario no authenticado',
            ], Response::HTTP_UNAUTHORIZED);
        }

        $docente = ItDocente::where('us_codigo', $usuario->us_codigo)->first();

        $clasesMes = ItHorarioMatricula::selectRaw('MONTH(hm_fecha_inicio) as mes, COUNT(*) as total')
            ->whereYear('hm_fecha_inicio', date('Y'))
            ->where('do_codigo', $docente->do_codigo)
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        return response()->json([
            'status' => true,
            'data' => $clasesMes,
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list horarios'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
}
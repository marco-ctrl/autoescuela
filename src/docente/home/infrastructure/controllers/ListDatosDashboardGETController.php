<?php

namespace Src\docente\home\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use App\Models\User;
use App\Services\DashboardDocente;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListDatosDashboardGETController extends Controller { 

    public $dashboardDocente;

    public function __construct(DashboardDocente $dashboardDocente) {
        $this->dashboardDocente = $dashboardDocente;
    }

 public function index(User $usuario): JsonResponse { 
    try {
        $docente = ItDocente::where('us_codigo', $usuario->us_codigo)->first();
        
        $cards = $this->dashboardDocente->getData($docente->do_codigo);

        return response()->json([
            'status' => true,
            'data' => $cards,
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list horarios asistencia'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
 }
}
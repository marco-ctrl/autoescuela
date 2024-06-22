<?php

namespace Src\manager\home\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use App\Models\User;
use App\Services\DashboardManager;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListDatosDashboardGETController extends Controller { 

    public $dashboardManager;

    public function __construct(DashboardManager $dashboardManager) {
        $this->dashboardManager = $dashboardManager;
    }

 public function index(User $usuario): JsonResponse { 
    try {
        //$docente = ItDocente::where('us_codigo', $usuario->us_codigo)->first();
        
        $cards = $this->dashboardManager->getData($usuario->us_codigo);

        return response()->json([
            'status' => true,
            'data' => $cards,
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list datos dashboard'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
 }
}
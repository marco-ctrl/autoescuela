<?php

namespace Src\manager\pago_cuota\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use App\Services\DashboardAdmin;
use App\Services\Dashboardmanager;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListMovimientosMesGETController extends Controller
{

    public $dashboardmanager;

    public function __construct(Dashboardmanager $dashboardmanager){
        $this->dashboardmanager = $dashboardmanager;
    }
    
    public function index(): JsonResponse
    {
        try {
            $data = $this->dashboardmanager->getDataPie();
            
            return response()->json([
                'status' => true,
                'data' => $data,
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

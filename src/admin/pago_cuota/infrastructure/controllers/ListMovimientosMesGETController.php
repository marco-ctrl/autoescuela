<?php

namespace Src\admin\pago_cuota\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use App\Services\DashboardAdmin;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListMovimientosMesGETController extends Controller
{

    public $dashboardAdmin;

    public function __construct(DashboardAdmin $dashboardAdmin){
        $this->dashboardAdmin = $dashboardAdmin;
    }
    
    public function index(): JsonResponse
    {
        try {
            $data = $this->dashboardAdmin->getDataPie();
            
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

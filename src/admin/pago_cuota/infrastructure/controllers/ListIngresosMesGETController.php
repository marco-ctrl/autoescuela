<?php

namespace Src\admin\pago_cuota\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItCuota;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListIngresosMesGETController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $ingresosPorMes = ItCuota::selectRaw('MONTH(ct_fecha_pago) as mes, SUM(ct_importe) as total')
                ->whereYear('ct_fecha_pago', date('Y'))
                ->groupBy('mes')
                ->orderBy('mes')
                ->get();
            return response()->json([
                'status' => true,
                'data' => $ingresosPorMes,
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

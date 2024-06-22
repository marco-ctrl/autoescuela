<?php

namespace Src\manager\pago_cuota\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItComprobante;
use App\Models\ItComprobantePago;
use App\Models\ItCuota;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ListIngresosMesGETController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $ingresosPorMes = ItComprobantePago::selectRaw('MONTH(cp_fecha_cobro) as mes, SUM(cp_pago) as total')
                ->whereYear('cp_fecha_cobro', date('Y'))
                ->where(function($query){
                    $query->where('cp_tipo', 1)
                        ->orWhere('cp_tipo', 2);
                })
                ->where('us_codigo', auth()->user()->us_codigo)
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

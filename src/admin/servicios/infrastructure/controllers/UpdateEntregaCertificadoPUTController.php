<?php

namespace Src\admin\servicios\infrastructure\controllers;

use App\Helpers\CalcularSaldo;
use App\Http\Controllers\Controller;
use App\Models\ItProgramacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

final class UpdateEntregaCertificadoPUTController extends Controller
{
    public function index(ItProgramacion $programacion): JsonResponse
    {
        try {
            $programacion = ItProgramacion::where('pg_codigo', $programacion->pg_codigo)->first();
            
            if (!$programacion) {
                return response()->json([
                    'status' => false,
                    'message' => __('Programacion not found'),
                ], Response::HTTP_NOT_FOUND);
            }

            $saldo = CalcularSaldo::calcularAntecedentesPenales($programacion->pg_codigo);
            if($saldo > 0)
            {
                return response()->json([
                    'status' => false,
                    'message' => __('El certificado no se puede entregar porque aun tiene saldo pendiente'),
                ], Response::HTTP_BAD_REQUEST);
            }
            
            $programacion->sv_estado = 1;
            $programacion->sv_usuario_entrega = auth()->user()->us_codigo;
            $programacion->sv_fecha_entrega = date('Y-m-d H:i:s');
            $programacion->pg_updated = date('Y-m-d H:i:s');
            $programacion->save();

            return response()->json([
                'status' => true,
                'message' => __('Certificado entregado correctamente'),
                'data' => $programacion,
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Error al entregar el certificado'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

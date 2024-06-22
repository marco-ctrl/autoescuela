<?php

namespace Src\manager\docente\infrastructure\controllers;

use App\Helpers\ObtenerCorrelativo;
use App\Helpers\PagarDocente;
use App\Http\Controllers\Controller;
use App\Models\ItComprobante;
use App\Models\ItComprobantePago;
use App\Models\ItDocente;
use App\Models\ItHorarioMatricula;
use App\Models\ItPagoDocente;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Src\manager\docente\infrastructure\validators\StorePagoDocenteRequest;
use Symfony\Component\HttpFoundation\Response;

final class StorePagoDocentePOSTController extends Controller
{
    public function index(StorePagoDocenteRequest $request): JsonResponse
    {
        try {
            $docente = ItDocente::find($request->codigo);
            $usuario = User::find(auth()->user()->us_codigo);

            $horas = ItHorarioMatricula::where('do_codigo', $docente->do_codigo)
                ->where('hm_total_pagar', null)
                ->orderBy('hm_fecha_inicio', 'asc')
                ->limit($request->horas_pago)
                ->get();

            $fechaHoras = [];

            foreach ($horas as $hora) {
                $hora->hm_total_pagar = $docente->do_pago_hora;
                $hora->hm_fecha_pago = date('Y-m-d H:i:s');
                $hora->hm_usuario_pago = $usuario->us_codigo;
                $hora->save();

                $fechaHoras[] = [
                    'codigo_horario' => $hora->hm_codigo,
                    'fecha_hora' => $hora->hm_fecha_inicio,
                    'fecha_pago' => $hora->hm_fecha_pago,
                    'pago_hora' => $hora->hm_total_pagar,
                    'usuario' => $usuario->trabajador->tr_nombre . ' ' . $usuario->trabajador->tr_apellido,
                ];
            }

            $fechaHoras = json_encode($fechaHoras, JSON_UNESCAPED_UNICODE);

            $pagoDocente = ItPagoDocente::create([
                'do_codigo' => $docente->do_codigo,
                'pd_horas_pagadas' => $horas->count(),
                'pd_horas_pendiente' => PagarDocente::cantidadHorasNoPagadas($docente->do_codigo),
                'pd_descripcion' => 'PAGO DE SERVICIOS DOCENTE CANTIDAD DE HORAS ' . $horas->count(),
                'pd_monto_total' => $horas->sum('hm_total_pagar'),
                'pd_created' => date('Y-m-d H:i:s'),
                'pd_updated' => date('Y-m-d H:i:s'),
                'pd_fecha_hora' => $fechaHoras,
                'us_codigo' => auth()->user()->us_codigo,

            ]);

            $detalle = [
                [
                    'CodProducto' => 3,
                    'Producto' => $pagoDocente->pd_descripcion,
                    'Cantidad' => $pagoDocente->pd_horas_pagadas,
                    'Precio' => $pagoDocente->pd_monto_total,
                ],
            ];

            $data = [
                'detalle' => $detalle,
                'persona' => $docente->do_nombre . ' ' . $docente->do_apellido,
            ];

            $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

            $comprobantePago = ItComprobantePago::create([
                "cp_tipo" => 3,
                "cp_correlativo" => ObtenerCorrelativo::obtenerCorrelativoEgresos() + 1,
                "cp_fecha_cobro" => date('Y-m-d H:i:s'),
                "us_codigo" => auth()->user()->us_codigo,
                "cp_tipo_pago" => 1,
                "cp_pago" => $pagoDocente->pd_monto_total,
                "cp_estado" => 1,
                "cp_created" => date('Y-m-d H:i:s'),
                "cp_updated" => date('Y-m-d H:i:s'),
                "cp_informacion" => $jsonData,

            ]);

            return response()->json([
                'status' => true,
                'message' => 'Pago Docente realizado correctamente',
                'data' => $pagoDocente,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

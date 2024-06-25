<?php

namespace Src\manager\servicios\infrastructure\controllers;

use App\Helpers\ObtenerCorrelativo;
use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use App\Models\ItCuota;
use App\Models\ItEstudiante;
use App\Models\ItPagoCuota;
use App\Models\ItProgramacion;
use App\Models\ItSerie;
use App\Models\ItServicio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class UpdatePagoCuotasPUTController extends Controller
{
    public function index(ItProgramacion $programacion, Request $request): JsonResponse
    {
        try {
            /*$apertura = ItArqueoCaja::where('ac_codigo', $request->caja)
            ->where('ac_estado', 1)
            ->first();

            if(!$apertura){
            return response()->json([
            'status' => false,
            'message' => 'No se puede registrar un ingreso debido a que la caja se encuentra cerrada',
            ], Response::HTTP_BAD_REQUEST);
            }*/

            $programacion = ItProgramacion::where('pg_codigo', $programacion->pg_codigo)->first();
            //dd($programacion);
            if (!$programacion) {
                return response()->json([
                    'status' => false,
                    'message' => __('Programacion not found'),
                ], Response::HTTP_NOT_FOUND);
            }

            $cancelado = ItCuota::where('pg_codigo', $programacion->pg_codigo)
                ->sum('ct_importe');

            $servicio = ItServicio::find(1);
            $cancelado += $request->pc_monto;

            if ($cancelado > $servicio->sv_precio) {
                return response()->json([
                    'status' => false,
                    'message' => __('El monto a pagar excede el monto total del certificado de antecedentes penales'),
                ], Response::HTTP_OK);
            }

            $programacion->pg_cuotas = $programacion->pg_cuotas + 1;
            $programacion->pg_estado = 1;
            $programacion->pg_updated = date('Y-m-d H:i:s');
            $programacion->save();

            $numeroCuota = ItCuota::where('pg_codigo', $programacion->pg_codigo)
                ->max('ct_numero');

            $cuota = ItCuota::create([
                'pg_codigo' => $programacion->pg_codigo,
                'ct_numero' => $numeroCuota + 1,
                'ct_importe' => $request->pc_monto,
                'ct_fecha_pago' => date('Y-m-d'),
                'ct_estado' => 1,
                'ct_created' => date('Y-m-d H:i:s'),
                'ct_updated' => date('Y-m-d H:i:s'),
            ]);

            if (!$cuota) {
                return response()->json([
                    'status' => false,
                    'message' => __('Failed to created the cuota'),
                ], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $pagoCuota = ItPagoCuota::create([
                'pc_tipo' => $request->pc_tipo,
                'pc_monto' => $request->pc_monto,
                'pc_fecha_pago' => date('Y-m-d'),
                'pc_estado' => 1,
                'pc_created' => date('Y-m-d H:i:s'),
                'pc_updated' => date('Y-m-d H:i:s'),
                'ct_codigo' => $cuota->ct_codigo,
                'us_codigo' => auth()->user()->us_codigo,
            ]);

            if (!$pagoCuota) {
                return response()->json([
                    'status' => false,
                    'message' => __('Failed to created the pago cuota'),
                ]);
            }

            $cpTipo = $request->pc_tipo == 0 ? 1 : 2;

            $estudiante = ItEstudiante::find($programacion->es_codigo);

            $servicio = ItServicio::find($programacion->sv_codigo);
            $descripcion = $servicio->sv_descripcion;

            $serie = ItSerie::where('sr_codigo', 1)->first();

            $data = [
                "emisionpago" => $cuota->ct_created,
                "descripcion" => 'PAGO ' . $descripcion . '/' . "CUOTA N°-" . $cuota->ct_numero,
                "fechacuota" => $cuota->ct_fecha_pago,
                "documentoes" => $estudiante->es_documento,
                "estudiante" => $estudiante->es_nombre . ' ' . $estudiante->es_apellido,
                "pago" => $cuota->ct_importe,
                "monto" => $cuota->ct_importe,
                "serie" => $serie->sr_descripcion,
                "correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos(),
                "tipo" => "TICKET",
            ];

            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            //dd($json);
            //$json = ObtenerInformacionPago::obtenerInformacionPagoCertificado($estudiante, $cuota, $request->documento, $descripcion);
            //dd($json);

            $comprobantePago = ItComprobantePago::create([
                "cp_tipo" => 2,
                "pc_codigo" => $pagoCuota->pc_codigo,
                "sr_codigo" => 1,
                "cp_correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos() + 1,
                "cp_fecha_cobro" => date('Y-m-d H:i:s'),
                "us_codigo" => auth()->user()->us_codigo,
                "cp_tipo_pago" => $cpTipo,
                "cp_pago" => $request->pc_monto,
                "cp_facturacion" => null,
                "cp_estado" => 1,
                "cp_created" => date('Y-m-d H:i:s'),
                "cp_updated" => date('Y-m-d H:i:s'),
                "cp_informacion" => $json,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('Pago cuota created successfully'),
                'data' => $comprobantePago,
            ]);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to created the matricula'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

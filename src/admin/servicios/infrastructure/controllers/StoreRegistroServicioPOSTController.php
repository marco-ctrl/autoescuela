<?php

namespace Src\admin\servicios\infrastructure\controllers;

use App\Helpers\ObtenerCorrelativo;
use App\Helpers\ObtenerInformacionPago;
use App\Http\Controllers\Controller;
use App\Models\ItArqueoCaja;
use App\Models\ItCertificadoAntecedentes;
use App\Models\ItComprobantePago;
use App\Models\ItCuota;
use App\Models\ItEstudiante;
use App\Models\ItPagoCuota;
use App\Models\ItProgramacion;
use App\Models\ItServicio;
use App\Models\ItSerie;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\admin\servicios\infrastructure\validators\StoreRegistroServicioRequest;
use Symfony\Component\HttpFoundation\Response;

final class StoreRegistroServicioPOSTController extends Controller
{
    public function index(StoreRegistroServicioRequest $request): JsonResponse
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
            
            $programacion = ItProgramacion::create([
                'es_codigo' => $request->es_codigo,
                'ye_codigo' => 1,
                'pg_cuotas' => 1,
                'pr_codigo' => 1,
                'pg_created' => now()->format('Y-m-d H:s:i'),
                'pg_updated' => now()->format('Y-m-d H:s:i'),
                'us_codigo' => auth()->user()->us_codigo,
                'pg_estado' => 1,
                'ma_codigo' => null,
                'sv_codigo' => $request->servicio,
                'sv_costo' =>$request->costo,
            ]);

            if (!$programacion) {
                return response()->json([
                    'status' => false,
                    'message' => __('error al guardar programacion'),
                ], Response::HTTP_NOT_FOUND);
            }

            $cuota = ItCuota::create([
                'pg_codigo' => $programacion->pg_codigo,
                'ct_numero' => 1,
                'ct_importe' => $request->importe,
                'ct_fecha_pago' => now()->format('Y-m-d'),
                'ct_estado' => 1,
                'ct_created' => now()->format('Y-m-d'),
                'ct_updated' => now()->format('Y-m-d'),
            ]);

            if (!$cuota) {
                return response()->json([
                    'status' => false,
                    'message' => __('error al guardar cuota'),
                ], Response::HTTP_NOT_FOUND);
            }

            $pagoCuota = ItPagoCuota::create([
                'pc_tipo' => 0,
                'pc_monto' => $cuota->ct_importe,
                'pc_recurso' => null,
                'pc_created' => now()->format('Y-m-d H:i:s'),
                'pc_updated' => now()->format('Y-m-d H:i:s'),
                'pc_estado' => 1,
                'ct_codigo' => $cuota->ct_codigo,
                'us_codigo' => auth()->user()->us_codigo,
            ]);

            if (!$pagoCuota) {
                return response()->json([
                    'status' => false,
                    'message' => __('error al guardar pago cuota'),
                ], Response::HTTP_NOT_FOUND);
            }

            $estudiante = ItEstudiante::find($request->es_codigo);
            
            $servicio = ItServicio::find($programacion->sv_codigo);
            $descripcion = $servicio->sv_descripcion;
            
            $serie = ItSerie::where('sr_codigo', 1)->first();

            $data = [
                "emisionpago" => $cuota->ct_created,
                "descripcion" =>   'PAGO ' . $descripcion . '/' . "CUOTA N°-" . $cuota->ct_numero,
                "fechacuota" => $cuota->ct_fecha_pago,
                "documentoes" => $estudiante->es_documento,
                "estudiante" => $estudiante->es_nombre . ' ' . $estudiante->es_apellido,
                "pago" => $cuota->ct_importe,
                "monto" => $cuota->ct_importe,
                "serie" => $serie->sr_descripcion,
                "correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos(),
                "tipo" => "TICKET"
            ];
        
            $json = json_encode($data, JSON_UNESCAPED_UNICODE);
            

            $comprobantePago = ItComprobantePago::create([
                "cp_tipo" => 2,
                "sr_codigo" => 1,
                "pc_codigo" => $pagoCuota->pc_codigo,
                "cp_correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos() + 1,
                "cp_fecha_cobro" => date('Y-m-d H:i:s'),
                "us_codigo" => auth()->user()->us_codigo,
                "cp_tipo_pago" => 1,
                "cp_pago" => $request->importe,
                "cp_estado" => 1,
                "cp_created" => date('Y-m-d H:i:s'),
                "cp_updated" => date('Y-m-d H:i:s'),
                "cp_informacion" => $json,
                //'ac_codigo' => $request->caja
            ]);

            return response()->json([
                'status' => true,
                'message' => __('Servocio Registrado exitosamente'),
                'data' => $comprobantePago,
                //'data' => $request->all(),
            ], Response::HTTP_OK);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Error al registrar servicio'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

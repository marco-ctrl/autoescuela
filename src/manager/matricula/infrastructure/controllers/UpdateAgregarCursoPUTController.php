<?php

namespace Src\manager\matricula\infrastructure\controllers;

use App\Helpers\ObtenerCorrelativo;
use App\Helpers\ObtenerInformacionPago;
use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use App\Models\ItCuota;
use App\Models\ItMatricula;
use App\Models\ItPagoCuota;
use App\Models\ItProgramacion;
use App\Models\ItEstudiante;
use App\Models\ItCurso;
use App\Models\ItSerie;
use Illuminate\Http\JsonResponse;
use Src\manager\matricula\infrastructure\validators\UpdateAgregarCursoRequest;
use Symfony\Component\HttpFoundation\Response;

final class UpdateAgregarCursoPUTController  extends Controller
{
    public function index(ItMatricula $matricula, UpdateAgregarCursoRequest $request): JsonResponse
    {
        try {
            $matriculas = ItMatricula::find($matricula->ma_codigo);

            if($matriculas->cu_codigo != null){
                return response()->json([
                    'status' => false,
                    'message' => __('No se puede adicionar un curso para este numero de matricula porque ya tiene un curso asignado'),
                ], Response::HTTP_OK);
            }
            
            $matriculas->cu_codigo = $request->cu_codigo;
            $matriculas->ma_duracion_curso = $request->ma_duracion;
            $matriculas->ma_costo_curso = $request->ma_costo_curso;
            $matriculas->ma_costo_total = $matriculas->ma_costo_evaluacion + $request->ma_costo_curso;
            $matriculas->save();

            $programacion = ItProgramacion::where('ma_codigo', $matricula->ma_codigo)->first();

            if (!$programacion) {
                return response()->json([
                    'status' => false,
                    'message' => __('Programacion not found'),
                ], Response::HTTP_NOT_FOUND);
            }

            $cancelado = ItCuota::where('pg_codigo', $programacion->pg_codigo)
                ->sum('ct_importe');
            
            if(($cancelado + $request->pc_monto) > $matricula->ma_costo_total){
                return response()->json([
                    'status' => false,
                    'message' => __('El monto a pagar excede el monto total de la matricula'),
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
                'ct_importe' => $request->importe,
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
                'pc_tipo' => 0,
                'pc_monto' => $request->importe,
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
            
            $estudiante = ItEstudiante::find($matriculas->es_codigo);
            $curso = ItCurso::find($matriculas->cu_codigo);
            $descripcion = $curso->cu_descripcion;
            
            $serie = ItSerie::where('sr_codigo', 1)->first();

            $data = [
                "emisionpago" => $cuota->ct_created,
                "descripcion" =>   'PAGO ADICION CURSO ' . $descripcion . '/' . "CUOTA N°-" . $cuota->ct_numero,
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
                    "pc_codigo" => $pagoCuota->pc_codigo,
                    "sr_codigo" => 1,
                    "cp_correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos() + 1,
                    "cp_fecha_cobro" => date('Y-m-d H:i:s'),
                    "us_codigo" => auth()->user()->us_codigo,
                    "cp_tipo_pago" => 1,
                    "cp_pago" => $pagoCuota->pc_monto,
                    "cp_facturacion" => NULL,
                    "cp_estado" => 1,
                    "cp_created" => date('Y-m-d H:i:s'),
                    "cp_updated" => date('Y-m-d H:i:s'),
                    "cp_informacion" => $json,
                    //"ac_codigo" => $request->caja
            ]);
            return response()->json([
                'status' => true,
                'data' => $comprobantePago,
                'message' => __('Curso asignado correctamente'),
                'duracion' => $matriculas->ma_duracion_curso,
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to save curso'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    } 
}

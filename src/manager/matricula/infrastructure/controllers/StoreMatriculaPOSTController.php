<?php

namespace Src\manager\matricula\infrastructure\controllers;

use App\Helpers\ObtenerCorrelativo;
use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use App\Models\ItCuota;
use App\Models\ItMatricula;
use App\Models\ItPagoCuota;
use App\Models\ItProgramacion;
use Illuminate\Http\JsonResponse;
use Src\manager\matricula\infrastructure\validators\StoreMatriculaValidatorRequest;
use Symfony\Component\HttpFoundation\Response;

final class StoreMatriculaPOSTController extends Controller
{
    public function index(StoreMatriculaValidatorRequest $request): JsonResponse
    {
        try {
           if($request->curso == null && $request->ma_evaluacion == "0" ){
                return response()->json([
                    'status' => false,
                    'message' => __('Debe seleccionar un curso o evaluacion para poder registrar la matrícula'),
                ], Response::HTTP_OK);
            }
            
            $duracionCurso = 0;
            $costoCurso = 0;
            $costoEvluacion = 0;
            $costoTotal = 0;
            $curso = null;

            if ($request->ma_evaluacion == "1" ) {
                $costoEvluacion = $request->ma_costo_evaluacion;
                if($request->ma_costo_curso != null){
                    $costoTotal = $request->ma_costo_curso + $request->ma_costo_evaluacion;
                    $costoCurso = $request->ma_costo_curso;
                    $duracionCurso = $request->ma_duracion;
                    $curso = $request->cu_codigo;
                }
                $costoTotal = $request->ma_costo_evaluacion;
            }
                
            if ($request->ma_evaluacion == "0") {
                $costoTotal = $request->ma_costo_curso;
                $costoCurso = $request->ma_costo_curso;
                $duracionCurso = $request->ma_duracion;
                $curso = $request->cu_codigo;
            }

            $matricula = ItMatricula::create([
                'ma_fecha' => now()->format('Y-m-d H:i:s'),
                'ma_estado' => 1,
                'es_codigo' => $request->es_codigo,
                'ma_ver_promedio' => 1,
                'cu_codigo' => $curso,
                'am_codigo' => $request->am_codigo,
                'se_codigo' => $request->se_codigo,
                'ma_categoria' => $request->ma_categoria,
                'ma_costo_curso' => $costoCurso,
                'ma_costo_evaluacion' => $costoEvluacion,
                'ma_evaluacion' => $request->ma_evaluacion,
                'ma_costo_total' => $costoTotal,
                'ma_duracion_curso' => $duracionCurso,
                'us_codigo_create' => auth()->user()->us_codigo,
            ]);

            if (!$matricula) {
                return response()->json([
                    'status' => false,
                    'message' => __('error al guardar matricula'),
                ], Response::HTTP_NOT_FOUND);
            }

            $programacion = ItProgramacion::create([
                'es_codigo' => $matricula->es_codigo,
                'ye_codigo' => 1,
                'pg_cuotas' => 1,
                'pr_codigo' => 1,
                'pg_created' => now()->format('Y-m-d H:s:i'),
                'pg_updated' => now()->format('Y-m-d H:s:i'),
                'us_codigo' => auth()->user()->us_codigo,
                'pg_estado' => 1,
                'ma_codigo' => $matricula->ma_codigo,
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

            $data = [
                'detalle' => [
                    [
                        'CodProducto' => '1',
                        'Producto' => 'PAGO DE MATRICULA',
                        'Cantidad' => '1',
                        'Precio' => $matricula->ma_costo_total,
                    ],
                ],
                'estudiante' => $matricula->estudiante->es_nombre . ' ' . $matricula->estudiante->es_apellido,
                'codEstudiante' => $matricula->es_codigo,
                'serie' => 'TC01',
                'correlativo' => ObtenerCorrelativo::obtenerCorrelativoIngresos() + 1,
                'tipo' => 'TICKET',
            ];

            $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

            $comprobantePago = ItComprobantePago::create([
                "cp_tipo" => 1,
                "sr_codigo" => 1,
                "cp_correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos() + 1,
                "cp_fecha_cobro" => date('Y-m-d H:i:s'),
                "us_codigo" => auth()->user()->us_codigo,
                "cp_tipo_pago" => 1,
                "cp_pago" => $matricula->ma_costo_total,
                "cp_estado" => 1,
                "cp_created" => date('Y-m-d H:i:s'),
                "cp_updated" => date('Y-m-d H:i:s'),
                "cp_informacion" => $jsonData,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('matricula creado exitosamente'),
                'data' => $matricula,
                //'data' => $request->all(),
            ], Response::HTTP_OK);

        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to created the matricula'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

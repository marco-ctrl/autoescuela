<?php

namespace Src\manager\certificado_antecedentes\infrastructure\controllers;

use App\Helpers\ObtenerCorrelativo;
use App\Http\Controllers\Controller;
use App\Models\ItCertificadoAntecedentes;
use App\Models\ItComprobantePago;
use App\Models\ItCuota;
use App\Models\ItEstudiante;
use App\Models\ItPagoCuota;
use App\Models\ItProgramacion;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\manager\certificado_antecedentes\infrastructure\validators\StoreCertificadoAntecedentesRequest;
use Symfony\Component\HttpFoundation\Response;

final class StoreCertificadoAntecedentesPOSTController extends Controller
{
    public function index(StoreCertificadoAntecedentesRequest $request): JsonResponse
    {
        try {
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
                'ca_codigo' => 1
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
            $certificado = ItCertificadoAntecedentes::find(1);

            $data = [
                'detalle' => [
                    [
                        'CodProducto' => '1',
                        'Producto' => $certificado->ca_descripcion,
                        'Cantidad' => '1',
                        'Precio' => $request->importe,
                    ],
                ],
                'estudiante' => $estudiante->es_nombre . ' ' . $estudiante->es_apellido,
                'codEstudiante' => $estudiante->es_codigo,
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
                "cp_pago" => $request->importe,
                "cp_estado" => 1,
                "cp_created" => date('Y-m-d H:i:s'),
                "cp_updated" => date('Y-m-d H:i:s'),
                "cp_informacion" => $jsonData,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('Certificado de antecedentes penales creado exitosamente'),
                'data' => $comprobantePago,
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

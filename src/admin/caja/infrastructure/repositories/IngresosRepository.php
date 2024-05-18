<?php

namespace Src\admin\caja\infrastructure\repositories;

use App\Helpers\ObtenerCorrelativo;
use App\Models\ItComprobantePago;
use App\Models\ItCuota;
use App\Models\ItEstudiante;
use App\Models\ItPagoCuota;
use App\Models\ItProducto;
use App\Models\ItProgramacion;

class IngresosRepository
{
    public function store(array $data)
    {
        $detalles = $data['detalles'];
        $importe = 0;
        $detalleIngreso = [];

        $estudiante = ItEstudiante::find($data['estudiante']);

        foreach ($detalles as $detalle) {
            $producto = ItProducto::where('pr_descripcion', strtoupper($detalle['detalle']))
            ->where('pr_tipo_producto', '0')
            ->first();

            if(!$producto){
                $producto = ItProducto::create([
                    'pr_descripcion' => strtoupper($detalle['detalle']),
                    'pr_precio' => $detalle['precio'],
                    'pr_tipo' => 1,
                    'pr_created' => now()->format('Y-m-d H:s:i'),
                    'pr_updated' => now()->format('Y-m-d H:s:i'),
                    'pr_tipo_producto' => 0,
                    'pr_estado' => 1
                ]);
            }

            $detalleIngreso[] = [
                'CodProducto' => $producto->pr_codigo,
                'Producto' => $producto->pr_descripcion,
                'Cantidad' => $detalle['cantidad'],
                'Precio' => $detalle['precio'],
            ];
            $importe += ($detalle['precio'] * $detalle['cantidad']);
        }

        $data = [
            'detalle' => $detalleIngreso,
            'estudiante' => $estudiante->es_nombre . ' ' . $estudiante->es_apellido,
            'codEstudiante' => $estudiante->es_codigo,
            'serie' => 'TC01',
            'correlativo' => ObtenerCorrelativo::obtenerCorrelativoIngresos() + 1,
            'tipo' => 'TICKET',
        ];

        $programacion = ItProgramacion::create([
            'es_codigo' => $estudiante->es_codigo,
            'ye_codigo' => 1,
            'pg_cuotas' => 1,
            'pr_codigo' => 1,
            'pg_created' => now()->format('Y-m-d H:s:i'),
            'pg_updated' => now()->format('Y-m-d H:s:i'),
            'us_codigo' => auth()->user()->us_codigo,
            'pg_estado' => 1,
        ]);

        $cuota = ItCuota::create([
            'pg_codigo' => $programacion->pg_codigo,
            'ct_numero' => 1,
            'ct_importe' => $importe,
            'ct_fecha_pago' => now()->format('Y-m-d'),
            'ct_estado' => 1,
            'ct_created' => now()->format('Y-m-d'),
            'ct_updated' => now()->format('Y-m-d'),
        ]);

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

        $jsonData = json_encode($data, JSON_UNESCAPED_UNICODE);

        $comprobantePago = ItComprobantePago::create([
            "cp_tipo" => 1,
            "sr_codigo" => 1,
            "cp_correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos() + 1,
            "cp_fecha_cobro" => date('Y-m-d H:i:s'),
            "us_codigo" => auth()->user()->us_codigo,
            "cp_tipo_pago" => 1,
            "cp_pago" => $importe,
            "cp_estado" => 1,
            "cp_created" => date('Y-m-d H:i:s'),
            "cp_updated" => date('Y-m-d H:i:s'),
            "cp_informacion" => $jsonData,
        ]);

        return $comprobantePago;
    }
}

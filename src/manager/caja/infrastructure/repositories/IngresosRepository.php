<?php

namespace Src\manager\caja\infrastructure\repositories;

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

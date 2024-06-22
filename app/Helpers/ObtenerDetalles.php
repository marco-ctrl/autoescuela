<?php

namespace App\Helpers;

use App\Models\ItComprobantePago;

class ObtenerDetalles
{
    public static function obtenerInformacionIngresos(int $codigo)
    {
        $comprobante = ItComprobantePago::find($codigo);
        $informacion = $comprobante->cp_informacion;

        $informacion = json_decode($informacion, true);
        $detalles = '';

        if ($comprobante->cp_tipo == 1) {
            foreach ($informacion['detalle'] as $detalle) {
                $detalles .= $detalle['Producto'] . ', ';
            }

            return $informacionObtenida[] = [
                'estudiante' => $informacion['estudiante'],
                'detalles' => $detalles,
                'documento' => $informacion['serie'] . '-' . $informacion['correlativo'],
            ];
        }

        if ($comprobante->cp_tipo == 2) {
            return $informacionObtenida[] = [
                'estudiante' => $informacion['estudiante'],
                'detalles' => $informacion['descripcion'],
                'documento' => $informacion['serie'] . '-' . $informacion['correlativo'],
            ];
        }
    }

    public static function obtenerInformacionEgresos(int $codigo)
    {
        $comprobante = ItComprobantePago::find($codigo);
        $informacion = $comprobante->cp_informacion;

        $informacion = json_decode($informacion, true);
        $detalles = '';

        //dd($comprobante);

        if ($comprobante->cp_tipo == 3) {
            foreach ($informacion['detalle'] as $detalle) {
                $detalles .= $detalle['Producto'] . ', ';
            }
        }

        $persona = $informacion['persona'] ?? 'Sin Asignar';
        return $informacionObtenida[] = [
            'persona' => $persona,
            'detalles' => $detalles,
             
        ];

    }
}

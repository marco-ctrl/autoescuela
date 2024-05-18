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

        //dd($comprobante);
        
        if($comprobante->cp_tipo == 1){
            foreach($informacion['detalle'] as $detalle){
                $detalles .= $detalle['Producto'] . ', ';
            }

            return $informacionObtenida[]=[
                'estudiante' => $informacion['estudiante'],
                'detalles' => $detalles];
        }

        if($comprobante->cp_tipo == 2){
            return $informacionObtenida[]=[
                'estudiante' => $informacion['estudiante'],
                'detalles' => $informacion['descripcion']
            ];
        }
    }
}
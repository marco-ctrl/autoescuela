<?php
namespace App\Helpers;

use App\Models\ItComprobantePago;

class ObtenerCorrelativo
{
    //obtener correlativo de la tabla
    public static function obtenerCorrelativoIngresos(): int
    {
        $correlativo = ItComprobantePago::where('cp_tipo', 1)
            ->orWhere('cp_tipo', 2)
            ->max('cp_correlativo');

            if(!$correlativo){
                return 1;
            }

        return $correlativo;
    }

    public static function obtenerCorrelativoEgresos(): int
    {
        $correlativo = ItComprobantePago::where('cp_tipo', 3)
            ->max('cp_correlativo');

            if(!$correlativo){
                return 1;
            }
        return $correlativo;
    }
}

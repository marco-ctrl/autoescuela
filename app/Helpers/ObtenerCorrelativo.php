<?php
namespace App\Helpers;

use App\Models\ItComprobantePago;

class ObtenerCorrelativo
{
    //obtener correlativo de la tabla
    public static function obtenerCorrelativoIngresos(): int
    {
        $correlativo = ItComprobantePago::where('cp_tipo', 1)
            ->whereOr('cp_tipo', 2)
            ->max('cp_correlativo');

        return $correlativo;
    }

    public static function obtenerCorrelativoEgresos(): int
    {
        $correlativo = ItComprobantePago::where('cp_tipo', 3)
            ->max('cp_correlativo');

        return $correlativo;
    }
}

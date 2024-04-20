<?php
namespace App\Helpers;
use App\Models\ItHorarioMatricula;
use Carbon\Carbon;

class FechaInicioClases
{
    public static function fechaInicio($codigo)
    {
        $fecha_inicio = ItHorarioMatricula::where('ma_codigo', $codigo)->min('hm_fecha_inicio');
        
        return Carbon::parse($fecha_inicio)->format('d/m/Y');
    }
}
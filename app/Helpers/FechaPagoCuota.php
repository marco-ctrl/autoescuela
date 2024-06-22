<?php

namespace App\Helpers;

use App\Models\ItCuota;
use App\Models\ItProgramacion;
use Carbon\Carbon;

class FechaPagoCuota
{
    public static function fechaPrimeraCuota(int $codigoMatricula)
    {
        $programacion = ItProgramacion::where('ma_codigo', $codigoMatricula)->first();
        $cuota = ItCuota::where('pg_codigo', $programacion->pg_codigo)
            ->orderBy('ct_fecha_pago', 'asc')
            ->get();

        return Carbon::parse($cuota[0]->ct_fecha_pago)->format('d/m/Y');
    }

    public static function fechaUltimaCuota(int $codigoMatricula)
    {
        $programacion = ItProgramacion::where('ma_codigo', $codigoMatricula)->first();
        $cuota = ItCuota::where('pg_codigo', $programacion->pg_codigo)
            ->orderBy('ct_fecha_pago', 'desc')
            ->get();

        return Carbon::parse($cuota[0]->ct_fecha_pago)->format('d/m/Y');
    }

    public static function fechaPrimeraCuotaCertificado(int $codigo)
    {
        $programacion = ItProgramacion::where('pg_codigo', $codigo)->first();
        $cuota = ItCuota::where('pg_codigo', $programacion->pg_codigo)
            ->orderBy('ct_fecha_pago', 'asc')
            ->get();

        return Carbon::parse($cuota[0]->ct_fecha_pago)->format('d/m/Y');
    }

    public static function fechaUltimaCuotaCertificado(int $codigo)
    {
        $programacion = ItProgramacion::where('pg_codigo', $codigo)->first();
        $cuota = ItCuota::where('pg_codigo', $programacion->pg_codigo)
            ->orderBy('ct_fecha_pago', 'desc')
            ->get();

        return Carbon::parse($cuota[0]->ct_fecha_pago)->format('d/m/Y');
    }
}

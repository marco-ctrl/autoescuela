<?php
namespace App\Helpers;

use App\Models\ItCertificadoAntecedentes;
use App\Models\ItCurso;
use App\Models\ItMatricula;
use App\Models\ItProgramacion;
use App\Models\ItServicio;

class CalcularSaldo
{
    public static function calcular(int $ma_codigo)
    {
        $programacion = ItProgramacion::with('cuota')
        ->where('ma_codigo', $ma_codigo)
        ->first();

        $matricula = ItMatricula::find($ma_codigo);
        $importe = $programacion->cuota->sum('ct_importe');
        
        $saldo = $matricula->ma_costo_total - $importe;
        
        return $saldo;
    }

    public static function calcularAntecedentesPenales(int $pg_codigo)
    {
        $programacion = ItProgramacion::with('cuota')
        ->where('pg_codigo', $pg_codigo)
        ->first();

        $importe = $programacion->cuota->sum('ct_importe');
        
        $saldo = $programacion->sv_costo - $importe;
        
        return $saldo;
    }
}
<?php
namespace App\Helpers;

use App\Models\ItCurso;
use App\Models\ItMatricula;
use App\Models\ItProgramacion;

class CalcularSaldo
{
    public static function calcular(int $ma_codigo)
    {
        $programacion = ItProgramacion::with('cuota')
        ->where('ma_codigo', $ma_codigo)
        ->first();

        if(!$programacion)
        {
            return $saldo = null;
        }

        $matricula = ItMatricula::find($ma_codigo);
        $importe = $programacion->cuota->sum('ct_importe');
        
        if($matricula->ma_costo == null)
        {
            $curso = ItCurso::find($matricula->cu_codigo);
            $matricula->ma_costo = $curso->cu_costo;
            $matricula->save();
        }
        $saldo = $matricula->ma_costo - $importe;
        
        return $saldo;
    }
}
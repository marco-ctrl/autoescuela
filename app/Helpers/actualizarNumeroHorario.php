<?php

namespace App\Helpers;

use App\Models\ItHorarioMatricula;

class actualizarNumeroHorario
{
    public static function actualizar(int $matricula): int
    {
        $horarioMatriculas = ItHorarioMatricula::where('ma_codigo', $matricula)
            ->orderBy('hm_fecha_inicio', 'asc')
            ->get();

        $numero = 1;
        if ($horarioMatriculas) {
            foreach ($horarioMatriculas as $hm) {
                $hm->hm_numero = $numero;
                $hm->save();
                $numero++;
            }
        }
        return $numero; // Retorna el número de horarios actualizados
    }
}

<?php

namespace App\Helpers;

use App\Models\ItDocente;
use App\Models\ItHorarioMatricula;
use App\Models\User;

class PagarDocente
{
    public static function cantidadHorasNoPagadas(int $codigo): int
    {
        $cantidad = ItHorarioMatricula::where('do_codigo', $codigo)
            ->where('hm_total_pagar', null)
            ->count();

        return $cantidad;
    }

    public static function cantidadHorasPagadas($codigo): int
    {
        $cantidad = ItHorarioMatricula::where('do_codigo', $codigo)
            ->where('hm_total_pagar', '>', 0)
            ->count();

        return $cantidad;
    }

    public static function horasPorPagar(ItDocente $docente, int $limite, User $usuario): ItHorarioMatricula
    {

        $horas = ItHorarioMatricula::where('do_codigo', $docente->do_codigo)
            ->where('hm_total_pagar', null)
            ->orderBy('hm_fecha_inicio', 'asc')
            ->limit($limite)
            ->get();

        foreach ($horas as $hora) {
            $hora->hm_fecha_pago = date('Y-m-d H:i:s');
            $hora->hm_total_pagar = $docente->do_pago_hora;
            $hora->hm_usuario_pago = $usuario->us_codigo;
            $hora->save();
        }

        /**/

        return $horas;
    }
}

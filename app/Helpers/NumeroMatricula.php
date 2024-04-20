<?php

namespace App\Helpers;

class NumeroMatricula
{
    public static function generar($matriculaId)
    {
        $anio = date('Y');
        $id_alumno = str_pad($matriculaId, 7, '0', STR_PAD_LEFT);
        $matricula = 'MA-' . $id_alumno;
        return $matricula;
    }
}
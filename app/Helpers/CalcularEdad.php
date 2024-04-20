<?php

namespace App\Helpers;

use Carbon\Carbon;

class CalcularEdad
{
    /**
     * Calcula la edad de una persona a partir de su fecha de nacimiento
     *
     * @param string $fechaNacimiento
     * @return int
     */
    public static function calcularEdad(string $fechaNacimiento): int
    {
        $fechaNacimiento = Carbon::parse($fechaNacimiento);
        $hoy = Carbon::now();
        $edad = $hoy->diffInYears($fechaNacimiento);

        return $edad;
    }
}
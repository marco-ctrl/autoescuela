<?php
namespace App\Helpers;

class SepararApellido
{
    public static function formatearApellidos($apellidos)
    {
        $apellidoCompleto = ltrim($apellidos);
        $apellidos = explode(" ", $apellidoCompleto);

        if (count($apellidos) >= 2) {
            if ($apellidos[0] == "DE" || $apellidos[0] == "DEL") {
                $apePaterno = $apellidos[0] . " " . $apellidos[1];
                $apeMaterno = implode(" ", array_slice($apellidos, 2)); // Combina las partes restantes en un solo string
                $apeMaterno = ltrim($apeMaterno);
            }
            if ($apellidos[1] == "LA") {
                $apePaterno = $apellidos[0] . " " . $apellidos[1] . " " . $apellidos[2];
                $apeMaterno = implode(" ", array_slice($apellidos, 3)); // Combina las partes restantes en un solo string
                $apeMaterno = ltrim($apeMaterno);
            } else {
                $apePaterno = $apellidos[0];
                $apeMaterno = implode(" ", array_slice($apellidos, 1)); // Combina las partes restantes en un solo string
                $apeMaterno = ltrim($apeMaterno);
            }
        } else {
            $apePaterno = "";
            $apeMaterno = $apellidoCompleto;
        }

        return [
            'ape_paterno' => $apePaterno,
            'ape_materno' => $apeMaterno,
        ];
    }
}
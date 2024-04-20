<?php

namespace App\Http\Resources\Admin;

use App\Models\ItHorarioMatricula;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class MatriculaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        $fecha_inscripcion = Carbon::parse($this->ma_fecha)->format('d/m/Y H:i:s');
        $apellidos = $this->formatearApellidos($this->estudiante->es_apellido);

        return [
            'foto' => $this->estudiante->es_foto,
            'nro_kardex' => '5',
            'fecha_inscripcion' => $fecha_inscripcion,
            'documento' => $this->estudiante->es_documento,
            'expedicion' => $this->estudiante->es_expedicion,
            'nombres' => $this->estudiante->es_nombre,
            'ape_paterno' => $apellidos['ape_paterno'],
            'ape_materno' => $apellidos['ape_materno'],
            'usuario' => null,
            'categoria' => $this->ma_categoria,
            'sede' => $this->sede->se_descripcion,
            'curso' => $this->curso->cu_descripcion,
            'costo' => 100,
            'cancelado' => true,
            'saldo' => 100,
            'fecha_inicio' => $this->fechaInicio($this->ma_codigo),
        ];
    }

    public function formatearApellidos($apellidos)
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

    public function fechaInicio($codigo)
    {
        $fecha_inicio = ItHorarioMatricula::where('ma_codigo', $codigo)->min('hm_fecha_inicio');
        
        return Carbon::parse($fecha_inicio)->format('d/m/Y');
    }

}

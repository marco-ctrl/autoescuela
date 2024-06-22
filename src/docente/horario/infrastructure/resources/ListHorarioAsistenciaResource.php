<?php

namespace Src\docente\horario\infrastructure\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ListHorarioAsistenciaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        switch($this->hm_color){
            case 'bg-danger':
                $color = '#F34F32';
                break;
            case 'bg-primary':
                $color = '#3287F3';
                break;
            case 'bg-success':
                $color = '#1CD740';
                break;
            case 'bg-warning':
                $color = '#DCEC1E';
                break;
            case 'bg-info':
                $color = '#17A2B8';
                break;
        }

        return [
            'id' => $this->hm_codigo,
            'start' => Carbon::parse($this->hm_fecha_inicio)->format('Y-m-d H:i:s'),
            'end' => Carbon::parse($this->hm_fecha_final)->format('Y-m-d H:i:s'),
            'fecha' => Carbon::parse($this->hm_fecha_inicio)->format('d/m/Y'),
            'hora_inicio' => Carbon::parse($this->hm_fecha_inicio)->format('H:i'),
            'hora_final' => Carbon::parse($this->hm_fecha_final)->format('H:i'),
            'color' => $color,
            'docente' => $this->docente->do_nombre . ' ' . $this->docente->do_apellido,
            'estudiante' => $this->matricula->estudiante->es_nombre . ' ' . $this->matricula->estudiante->es_apellido,
            'title' => 'Clase' . ' ' . $this->hm_numero,
            'comentario' => 'Asistencia',
            'observacion' => $this->ma_observacion_asistencia,
            'curso' => $this->matricula->curso->cu_descripcion,
            'asistencia' => $this->hm_asistencia,
            'justificacion' => $this->hm_justificacion,
            'numero' => $this->hm_numero,
            'tema' => $this->hm_tema,
            'nota' => $this->hm_nota
        ];
    }
}

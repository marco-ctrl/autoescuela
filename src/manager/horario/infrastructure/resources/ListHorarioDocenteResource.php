<?php

namespace Src\manager\horario\infrastructure\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ListHorarioDocenteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        return [
            'id' => $this->hm_codigo,
            'start' => Carbon::parse($this->hm_fecha_inicio)->format('Y-m-d H:i:s'),
            'end' => Carbon::parse($this->hm_fecha_final)->format('Y-m-d H:i:s'),
            'fecha' => Carbon::parse($this->hm_fecha_inicio)->format('d/m/Y'),
            'hora_inicio' => Carbon::parse($this->hm_fecha_inicio)->format('H:i'),
            'hora_final' => Carbon::parse($this->hm_fecha_final)->format('H:i'),
            'color' => 'gray',
            'docente' => $this->docente->do_nombre . ' ' . $this->docente->do_apellido,
            'title' => 'Ocupado',
            'observacion' => $this->hm_observacion_asistencia,
            'estudiante' => $this->matricula->estudiante->es_nombre . ' ' . $this->matricula->estudiante->es_apellido,
            'comentario' => 'Asistencia',
            'observacion' => $this->hm_observacion_asistencia,
            'numero' => $this->hm_numero,
            'tema' => $this->hm_tema,
            'nota' => $this->hm_nota,
            'categoria' => $this->matricula->ma_categoria,
            'curso' => $this->matricula->curso->cu_descripcion,
        ];
    }
}

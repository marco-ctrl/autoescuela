<?php

namespace Src\admin\horario\infrastructure\resources;

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
        ];
    }
}

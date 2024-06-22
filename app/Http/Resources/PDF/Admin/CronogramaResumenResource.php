<?php

namespace App\Http\Resources\PDF\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class CronogramaResumenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        Carbon::setLocale('es');
        
        $carbonDate = Carbon::parse($this->hm_fecha_inicio);
        $dayOfWeek = $carbonDate->locale('es')->dayName;

        return [
            'asistencia' => $this->hm_asistencia == 0 ? 'Falta' : 'Asistencia',
            'hora_inicio' => Carbon::parse($this->hm_fecha_inicio)->format('H:i'),
            'hora_fin' => Carbon::parse($this->hm_fecha_final)->format('H:i'),
            'clase' => $this->hm_numero,
            'dia' => $dayOfWeek,
            'fecha' => Carbon::parse($this->hm_fecha_inicio)->format('d/m/Y'),
            'curso' => $this->matricula->curso->cu_descripcion,
            'estudiante' => $this->matricula->estudiante->es_nombre . ' ' . $this->matricula->estudiante->es_apellido,
            'instructor' => $this->docente->do_nombre . ' ' . $this->docente->do_apellido,
        ];
    }
}

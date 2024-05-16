<?php

namespace Src\docente\horario\infrastructure\resources;

use App\Helpers\CalcularSaldo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ListHorarioGeneralResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        
        $firma = $this->hm_asistencia == 0 ? 'FALTA' : 'ASISTENCIA'; 
        
        $saldo = CalcularSaldo::calcular($this->matricula->ma_codigo);
        $numero_redondeado = round($saldo, 2);
        $numero_formateado = number_format($numero_redondeado, 2, '.', '');
        
        $textColor = $numero_redondeado > 0 ? 'text-danger' : 'text-success';

        $meses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
        
        $fecha_inicio = Carbon::parse($this->hm_fecha_inicio);
        $mes = $meses[$fecha_inicio->month - 1];
        $dia = $fecha_inicio->day;
        $year = $fecha_inicio->year;
        $fecha = $dia . ' de ' . $mes . ' del ' . $year;

        return [
            'id' => $this->hm_codigo,
            'hora' => Carbon::parse($this->hm_fecha_inicio)->format('H:i'),
            'matricula' => $this->matricula->ma_codigo,
            'textColor' => $textColor,
            'ci' => $this->matricula->estudiante->es_documento,
            'estudiante' => $this->matricula->estudiante->es_nombre . ' ' . $this->matricula->estudiante->es_apellido,
            'titulo' => 'INSTRUCTOR' . ' ' . $this->docente->do_nombre . ' ' . $this->docente->do_apellido . ' ' . $fecha,
            'observacion' => $this->ma_observacion_asistencia,
            'curso' => $this->matricula->curso->cu_descripcion,
            'firma' => $firma,
            'numero' => $this->hm_numero,
            'categoria' => $this->matricula->ma_categoria,
            'saldo' => $numero_formateado,
            'sede' => $this->matricula->sede->se_descripcion,
        ];
    }
}

<?php

namespace Src\admin\pago_cuota\infrastructure\resources;

use App\Helpers\CalcularSaldo;
use App\Helpers\FechaPagoCuota;
use App\Helpers\NumeroMatricula;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListPagoCuotaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        $fecha_inscripcion = Carbon::parse($this->ma_fecha)->format('d/m/Y H:i:s');
        
        $saldo = CalcularSaldo::calcular($this->ma_codigo);
        $numero_redondeado = round($saldo, 2);
        $numero_formateado = number_format($numero_redondeado, 2, '.', '');

        $usuario = null;
        if($this->usuario)
        {
            $usuario = $this->usuario->trabajador->tr_nombre . ' ' . $this->usuario->trabajador->tr_apellido;
        }

        $numero_matricula = NumeroMatricula::generar($this->ma_codigo);

        return [
            'id' => $this->ma_codigo,
            'matricula' => $numero_matricula,
            'fecha_inscripcion' => $fecha_inscripcion,
            'documento' => $this->estudiante->es_documento,
            'estudiante' => $this->estudiante->es_nombre . ' ' . $this->estudiante->es_apellido,
            'servicio' => $this->curso->cu_descripcion,
            'usuario' => $usuario,
            'inscripcion' => Carbon::parse($this->ma_fecha)->format('d/m/Y'),
            'costo' => $this->ma_costo_total,
            'primera_cuota' => FechaPagoCuota::fechaPrimeraCuota($this->ma_codigo),
            'ultima_cuota' => FechaPagoCuota::fechaUltimaCuota($this->ma_codigo),
            'cancelado' => $this->ma_costo_total - $numero_redondeado,
            'saldo' => $numero_formateado,
        ];
    }
}

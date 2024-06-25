<?php

namespace Src\manager\servicios\infrastructure\resources;

use App\Helpers\CalcularSaldo;
use App\Helpers\FechaPagoCuota;
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
        $saldo = CalcularSaldo::calcularAntecedentesPenales($this->pg_codigo);
        $numero_redondeado = round($saldo, 2);
        $numero_formateado = number_format($numero_redondeado, 2, '.', '');

        $usuario = null;
        if($this->usuario)
        {
            $usuario = $this->usuario->trabajador->tr_nombre . ' ' . $this->usuario->trabajador->tr_apellido;
        }

        $usuarioEntrega = null;
        if($this->usuarioEntregaCertificado)
        {
            $usuarioEntrega = $this->usuarioEntregaCertificado->trabajador->tr_nombre . ' ' . $this->usuarioEntregaCertificado->trabajador->tr_apellido;
        }

        //dd($this->servicio->sv_precio);
        return [
            'id' => $this->pg_codigo,
            'documento' => $this->estudiante->es_documento,
            'estudiante' => $this->estudiante->es_nombre . ' ' . $this->estudiante->es_apellido,
            'servicio' => $this->servicio->sv_descripcion,
            'usuario' => $usuario,
            'costo' => $this->sv_costo,
            'primera_cuota' => FechaPagoCuota::fechaPrimeraCuotaCertificado($this->pg_codigo),
            'ultima_cuota' => FechaPagoCuota::fechaUltimaCuotaCertificado($this->pg_codigo),
            'cancelado' => $this->sv_costo - $numero_redondeado,
            'saldo' => $numero_formateado,
            'entregado' => $this->sv_estado,
            'fecha_entrega' => $this->sv_fecha_entrega,
            'usuario_entrega' => $usuarioEntrega, 
        ];
    }
}

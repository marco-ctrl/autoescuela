<?php

namespace Src\manager\caja\infrastructure\resources;

use App\Helpers\ObtenerDetalles;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ListGetAllIngresosGETResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $informacion = ObtenerDetalles::obtenerInformacionIngresos($this->cp_codigo);
        
        return [
            'id' => $this->cp_codigo,
            'fecha' => Carbon::parse($this->cp_fecha_cobro)->format('d/m/Y H:i:s'),
            'monto' => $this->cp_pago,
            'detalle' => $informacion['detalles'],
            'usuario' => $this->usuario->trabajador->tr_nombre . ' ' . $this->usuario->trabajador->tr_apellido,
            'estudiante' => $informacion['estudiante'],
            'documento' => $informacion['documento'],
        ];
    }
}
<?php

namespace Src\admin\caja\infrastructure\resources;

use App\Helpers\ObtenerDetalles;
use App\Models\ItTrabajador;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ListGetAllEgresosGETResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $informacion = ObtenerDetalles::obtenerInformacionEgresos($this->cp_codigo);
        $trabajador = ItTrabajador::where('us_codigo', $this->usuario->us_codigo)->first();

        if(!$trabajador){
            $usuario = 'Sin asignar';
        }
        else{
            $usuario = $trabajador->tr_nombre . ' ' . $trabajador->tr_apellido;
        }

        //$persona = $informacion['persona'] ?? null;
        //$emitido = '';
        //$persona == null ? $emitido = $informacion['persona'] : $emitido = 'Sin asignar';

        return [
            'id' => $this->cp_codigo,
            'fecha' => Carbon::parse($this->cp_fecha_cobro)->format('d/m/Y H:i:s'),
            'monto' => $this->cp_pago,
            'detalle' => $informacion['detalles'],
            'usuario' => $usuario,
            'emitido' => $informacion['persona'],
        ];
    }
}
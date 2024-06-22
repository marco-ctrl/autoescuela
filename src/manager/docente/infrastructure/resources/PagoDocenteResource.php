<?php

namespace Src\manager\docente\infrastructure\resources;

use App\Helpers\PagarDocente;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PagoDocenteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->do_codigo,
            'foto' => $this->do_foto,
            'documento' => $this->do_documento,
            'docente' => $this->do_nombre . ' ' . $this->do_apellido,
            'pago_hora' => $this->do_pago_hora,
            'horas_pagadas' => PagarDocente::cantidadHorasPagadas($this->do_codigo),
            'horas_no_pagadas' => PagarDocente::cantidadHorasNoPagadas($this->do_codigo),
        ];
    }
}

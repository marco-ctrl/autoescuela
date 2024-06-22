<?php

namespace Src\manager\docente\infrastructure\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutocompleteDocenteResource extends JsonResource
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
            'value' => $this->do_documento . ' : ' . $this->do_nombre . ' ' . $this->do_apellido,
        ];
    }
}

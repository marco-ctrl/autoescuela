<?php

namespace Src\manager\estudiante\infrastructure\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutocompleteEstudianteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->es_codigo,
            'label' => $this->es_documento . ' : ' . $this->es_nombre . ' ' . $this->es_apellido,
        ];
    }
}

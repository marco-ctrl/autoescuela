<?php

namespace Src\admin\curso\infrastructure\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutoCompleteCursoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->cu_codigo,
            'value' => $this->cu_descripcion . ' - (' . $this->cu_costo . ' Bs.) - (' . $this->cu_duracion . ' Hrs.)',
        ];
    }
}

<?php

namespace Src\manager\producto\infrastructure\resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutoCompleteProductoIngresoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->pr_codigo,
            'value' => $this->pr_descripcion,
        ];
    }
}

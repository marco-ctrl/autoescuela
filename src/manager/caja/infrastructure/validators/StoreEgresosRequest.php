<?php

namespace Src\manager\caja\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StoreEgresosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'emitido' => 'required|string|max:150',
            'detalles' => 'required|array|min:1',
            'detalles.*.detalle' => 'required|string|max:255',
            'detalles.*.cantidad' => 'required|integer|min:1',
            'detalles.*.precio' => 'required|numeric|min:0',
            'detalles.*.total' => 'required|numeric|min:0',
        ];
    }

    public function messages()
    {
        return [
            'emitido.required' => 'El campo emitido es obligatorio.',
            'emitido.max' => 'El campo emitido no debe exceder los 150 caracteres.',
            'importe.min' => 'El campo precio debe ser al menos 1.',
            'detalles.required' => 'El campo detalles es obligatorio.',
            'detalles.array' => 'El campo detalles debe ser un array.',
            'detalles.min' => 'El campo detalles debe tener al menos un elemento.',
            'detalles.*.detalle.required' => 'El campo detalle es obligatorio.',
            'detalles.*.detalle.string' => 'El campo detalle debe ser una cadena de texto.',
            'detalles.*.detalle.max' => 'El campo detalle no debe tener más de 255 caracteres.',
            'detalles.*.cantidad.required' => 'El campo cantidad es obligatorio.',
            'detalles.*.cantidad.integer' => 'El campo cantidad debe ser un número entero.',
            'detalles.*.cantidad.min' => 'El campo cantidad debe ser al menos 1.',
            'detalles.*.precio.required' => 'El campo precio es obligatorio.',
            'detalles.*.precio.numeric' => 'El campo precio debe ser un número.',
            'detalles.*.precio.min' => 'El campo precio debe ser al menos 1.',
            'detalles.*.total.required' => 'El campo total es obligatorio.',
            'detalles.*.total.numeric' => 'El campo total debe ser un número.',
            'detalles.*.total.min' => 'El campo total debe ser al menos 1.',
        ];
    }

}

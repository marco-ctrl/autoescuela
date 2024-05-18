<?php

namespace Src\admin\caja\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StoreIngresosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'estudiante' => 'required|exists:it_estudiante,es_codigo',
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
            'estudiante.required' => 'El campo estudiante es obligatorio.',
            'estudiante.exists' => 'El campo estudiante no existe en la base de datos.',
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

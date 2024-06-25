<?php

namespace Src\manager\servicios\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistroServicioRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'es_codigo' => 'required|exists:it_estudiante,es_codigo',
            'servicio' => 'required|exists:it_servicio,sv_codigo',
            'importe' => 'required|numeric',
            'costo' => 'required|numeric',
        ];
    }

}

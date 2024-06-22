<?php

namespace Src\manager\certificado_antecedentes\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificadoAntecedentesRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'es_codigo' => 'required|exists:it_estudiante,es_codigo',
            'importe' => 'required|numeric'
        ];
    }

}

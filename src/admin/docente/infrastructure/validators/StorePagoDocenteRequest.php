<?php

namespace Src\admin\docente\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoDocenteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'codigo' => 'required|exists:it_docente,do_codigo',
            'horas_pago' => 'required|numeric|min:1' 
        ];
    }

}

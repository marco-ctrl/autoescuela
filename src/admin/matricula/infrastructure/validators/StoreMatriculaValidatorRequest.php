<?php

namespace Src\admin\matricula\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatriculaValidatorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'estudiante' => 'required|string|min:5',
            'curso' => 'required|string|min:5',
            'es_codigo' => 'required|numeric|exists:it_estudiante,es_codigo',
            'cu_codigo' => 'required|numeric|exists:it_curso,cu_codigo',
            'ma_duracion' => 'required|numeric|min:1',
            'ma_costo' => 'required|numeric|min:0',
            'salida' => 'nullable|numeric|exists:it_pabellon,pa_codigo',
            'am_codigo' => 'nullable|numeric|exists:it_ambiente,am_codigo',
            'se_codigo' => 'required|numeric|exists:it_sede,se_codigo',
            'ma_categoria' => 'required|alpha|in:M,A,B,C,M,P,T',
            'importe' => 'required|numeric|min:0',
            'saldo' => 'nullable',
            'detalle_recojo' => 'nullable|string|min:5',
        ];
    }

}

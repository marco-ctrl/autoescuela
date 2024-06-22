<?php

namespace Src\admin\matricula\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgregarCursoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'ma_costo_curso' => 'required|numeric|min:0',
            'ma_duracion' => 'required|numeric|min:1',
            'importe' => 'required|numeric|min:0',
            'cu_codigo' => 'required|exists:it_curso,cu_codigo'
        ];
    }
}
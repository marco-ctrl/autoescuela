<?php

namespace Src\manager\matricula\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMatriculaRequest extends FormRequest
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
            'se_codigo' => 'required|exists:it_sede,se_descripcion',
            'ma_categoria' => 'required|exists:it_categoria_ambiente,ca_descripcion'
        ];
    }
}
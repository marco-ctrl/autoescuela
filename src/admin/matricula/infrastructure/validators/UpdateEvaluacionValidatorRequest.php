<?php

namespace Src\admin\matricula\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEvaluacionValidatorRequest extends FormRequest
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
            'fecha' => 'required|date',
            'sede' => 'required|exists:it_sede,se_descripcion',
            'codigo' => 'required|exists:it_matricula,ma_codigo'
        ];
    }
}
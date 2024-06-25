<?php

namespace Src\manager\matricula\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAgregarEvaluacionValidatorRequest extends FormRequest
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
            'matricula' => 'required|exists:it_matricula,ma_codigo',
            'costo' => 'required|numeric|min:0',
            'importe' => 'required|numeric|min:0',
        ];
    }
}
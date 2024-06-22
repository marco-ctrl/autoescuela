<?php

namespace Src\manager\horario\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StoreHorarioValidatorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'docente' => 'required|string|min:5',
            'do_codigo' => 'required|exists:it_docente,do_codigo',
            'hm_color' => 'required|in:bg-success,bg-danger,bg-primary,bg-warning',
            'hm_fecha_inicio' => 'required|date_format:Y-m-d H:i:s',
            'ma_codigo' => 'required|exists:it_matricula,ma_codigo',
        ];
    }

}

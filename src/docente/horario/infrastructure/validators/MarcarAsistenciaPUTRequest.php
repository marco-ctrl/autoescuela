<?php

namespace Src\docente\horario\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class MarcarAsistenciaPUTRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'tema' => 'required|max:255|string',
            'nota' => 'nullable|max:100|numeric',
            'asistencia' => 'required|in:0,1',
            'justificacion' => 'nullable|string|max:255',
            'observacion' => 'nullable|string|max:255'
        ];
    }

}
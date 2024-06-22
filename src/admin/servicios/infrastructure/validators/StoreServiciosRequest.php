<?php

namespace Src\admin\servicios\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiciosRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'descripcion' => 'required|max:150',
            'precio' => 'required|numeric'
        ];
    }

}

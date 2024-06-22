<?php

namespace Src\manager\pago_cuota\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StorePagoCuotaPOSTRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pc_monto' => 'required|numeric|min:1',
            'pc_tipo' => 'required|in:0,1',
            'codigo' => 'required|exists:it_matricula,ma_codigo',
            'documento' => 'required|exists:it_comprobante,cb_descripcion'
        ];
    }

}

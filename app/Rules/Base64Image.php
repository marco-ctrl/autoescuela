<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class Base64Image implements Rule
{
    public function passes($attribute, $value)
    {
        // Verificar si la cadena proporcionada es una imagen codificada en base64 válida
        if (preg_match('/^data:image\/(\w+);base64,/', $value)) {
            return true;
        }
        
        return false;
    }

    public function message()
    {
        return 'El campo :attribute debe ser una imagen codificada en base64 válida.';
    }
}

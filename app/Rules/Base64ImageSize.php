<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\Rule;

class Base64ImageSize implements Rule
{
    protected $maxSizeKB;

    public function __construct($maxSizeKB)
    {
        $this->maxSizeKB = $maxSizeKB;
    }

    public function passes($attribute, $value)
    {
        // Decodificar la cadena base64 para obtener el tamaño de la imagen en bytes
        $decodedImage = base64_decode($value);
        $imageSizeKB = strlen($decodedImage) / 1024;

        return $imageSizeKB <= $this->maxSizeKB;
    }

    public function message()
    {
        return "El tamaño de la imagen :attribute no puede ser mayor que {$this->maxSizeKB} KB.";
    }
}

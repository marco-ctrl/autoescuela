<?php

namespace Src\manager\estudiante\infrastructure\validators;

use App\Rules\Base64Image;
use App\Rules\Base64ImageSize;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEstudianteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $fechaActual = now();
        $fechaMinima = $fechaActual->copy()->subYears(100);
        $fechaMaxima = $fechaActual->copy()->subYears(18);

        $estudiante = $this->route()->parameter('estudiante');

        $rules = [
            'es_documento' => "required|string|max:11|unique:it_estudiante,es_documento,{$estudiante->es_codigo},es_codigo",
            'es_expedicion' => 'required|in:LP,PD,OR,PT,CH,TJ,SC,CB,BE,QR',
            'es_tipodocumento' => 'required|in:1,2',
            'es_nombre' => 'required|string|max:30',
            'ape_paterno' => 'string|max:15',
            'ape_materno' => 'string|max:15',
            'es_nacimiento' => [
                'required',
                'date',
            ],
            'es_genero' => 'required|in:0,1',
            'es_direccion' => 'required|string|max:255',
            'es_celular' => 'required|string|regex:/^[0-9]{7,10}$/|max:10',
            'es_correo' => "nullable|string|email|max:100|unique:it_estudiante,es_correo,{$estudiante->us_codigo},us_codigo",
            'es_observacion' => 'nullable|string|max:255',
            'es_foto' => ['required', new Base64ImageSize(1024), new Base64Image],
        ];

        if ($this->input('es_tipodocumento') == 1) { // CI
            $rules['es_documento'] .= '|regex:/^\d{6,8}(?:-\d{1}[A-Z])?$/'; // Patrón para CI
            $rules['ape_paterno'] .= '|nullable';
            $rules['ape_materno'] .= '|required';
        } elseif ($this->input('es_tipodocumento') == 2) { // CE
            $rules['es_documento'] .= '|regex:/^E-\d+$/';
            $rules['ape_paterno'] .= '|required';
            $rules['ape_materno'] .= '|nullable';
        }

        return $rules; 
    }

}

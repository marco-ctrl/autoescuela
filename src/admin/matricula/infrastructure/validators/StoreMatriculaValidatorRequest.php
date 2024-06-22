<?php

namespace Src\admin\matricula\infrastructure\validators;

use Illuminate\Foundation\Http\FormRequest;

class StoreMatriculaValidatorRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
       $rules = [
            'estudiante' => 'required|string|min:5',
            'curso' => 'nullable|string|min:5',
            'es_codigo' => 'required|numeric|exists:it_estudiante,es_codigo',
            'cu_codigo' => 'nullable|numeric|exists:it_curso,cu_codigo',
            'ma_duracion' => 'nullable|numeric|min:1',
            'ma_costo_curso' => 'nullable|numeric|min:0',
            'ma_costo_evaluacion' => 'nullable|numeric|min:0',
            'ma_evaluacion' => 'required|in:0,1',
            'salida' => 'nullable|numeric|exists:it_pabellon,pa_codigo',
            'am_codigo' => 'nullable|numeric|exists:it_ambiente,am_codigo',
            'se_codigo' => 'required|numeric|exists:it_sede,se_codigo',
            'ma_categoria' => 'required|alpha',
            'importe' => 'required|numeric|min:0,max:'.$this->input('saldoTotal'),
            'saldo' => 'nullable|min:0',
            'detalle_recojo' => 'nullable|string|min:5',
        ];

        /*if($this->input('ma_evaluacion') == 0){
            $rules['importe'] .= 'max:'.$this->input('ma_costo_curso');
        }*/

        // if($this->input('ma_evaluacion') == 1)

        if($this->input('edad') >= 18 and $this->input('edad') < 21){
             $rules['ma_categoria'] .= '|in:M,P';
        }

        if($this->input('edad') >= 21 and $this->input('edad') < 23){
             $rules['ma_categoria'] .= '|in:M,P,A,T';
        }

        if($this->input('edad') >= 23 and $this->input('edad') < 29){
            $rules['ma_categoria'] .= '|in:M,P,A,T,B';
        }

        if($this->input('edad') >= 29){
            $rules['ma_categoria'] .= '|in:M,P,A,T,B,C';
        }

        return $rules; 
    }

}

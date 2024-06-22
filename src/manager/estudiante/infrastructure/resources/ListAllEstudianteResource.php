<?php

namespace Src\manager\estudiante\infrastructure\resources;

use App\Helpers\CalcularEdad;
use App\Helpers\SepararApellido;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class ListAllEstudianteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $edad = CalcularEdad::calcularEdad($this->es_nacimiento);

        $apellidos = SepararApellido::formatearApellidos($this->es_apellido);
        
        switch($this->es_estado)
        {
            case '1':
                $estado = 'A';
                $color = 'success';
                break;
            case '0':
                $estado = 'I';
                $color = 'danger';
         }

         if($this->us_codigo_create == null)
         {
            $usuario = null;
         }
         else{
            $usuario = $this->usuarioCreated->us_correo;
         }

        return [
            'id' => $this->es_codigo,
            'foto' => $this->es_foto,
            'documento' => $this->es_documento,
            'expedicion' => $this->es_expedicion,
            'tipo_documento' => $this->es_tipodocumento,
            'nombre' => $this->es_nombre,
            'apellido' => $this->es_apellido,
            'ape_paterno' => $apellidos['ape_paterno'],
            'ape_materno' => $apellidos['ape_materno'],
            'fecha_nacimiento' => $this->es_nacimiento,
            'correo' => $this->es_correo,
            'direccion' => $this->es_direccion,
            'celular' => $this->es_celular,
            'usuario' => $usuario,
            'edad' => $edad,
            'estado' => $estado,
            'color' => $color,
            'observacion' => $this->es_observacion,
            'genero' => $this->es_genero,
        ];
    }
}

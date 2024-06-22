<?php

namespace Src\manager\matricula\infrastructure\resources;

use App\Helpers\CalcularEdad;
use App\Helpers\CalcularSaldo;
use App\Helpers\FechaInicioClases;
use App\Helpers\NumeroMatricula;
use App\Helpers\SepararApellido;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ListAllMatriculaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */

    public function toArray(Request $request): array
    {
        if($this->ma_detalle_recojo == null){
            $detalle = 'Ninguno';
        }else{
            $detalle = $this->ma_detalle_recojo;
        }

        $fecha_inscripcion = Carbon::parse($this->ma_fecha)->format('d/m/Y H:i:s');
        $apellidos = SepararApellido::formatearApellidos($this->estudiante->es_apellido);
        $edad = CalcularEdad::calcularEdad($this->estudiante->es_nacimiento);

        $saldo = CalcularSaldo::calcular($this->ma_codigo);
        $numero_redondeado = round($saldo, 2);
        $numero_formateado = number_format($numero_redondeado, 2, '.', '');

        $usuario = null;
        if($this->usuario)
        {
            $usuario = $this->usuario->trabajador->tr_nombre . ' ' . $this->usuario->trabajador->tr_apellido;
        }

        $numero_matricula = NumeroMatricula::generar($this->ma_codigo);

        $fecha_evaluacion = 'Sin Asignar';
        if($this->ma_fecha_evaluacion != null){
            $fecha_evaluacion = $this->ma_fecha_evaluacion;
            $fecha_evaluacion = Carbon::parse($fecha_evaluacion)->format('d/m/Y H:i:s');
        }

        return [
            'id' => $this->ma_codigo,
            'foto' => $this->estudiante->es_foto,
            'nro_kardex' => $this->ma_codigo,
            'nro_matricula' => $numero_matricula,
            'fecha_inscripcion' => $fecha_inscripcion,
            'documento' => $this->estudiante->es_documento,
            'expedicion' => $this->estudiante->es_expedicion == null ? '' : $this->estudiante->es_expedicion,
            'nombres' => $this->estudiante->es_nombre,
            'apellidos' => $this->estudiante->es_apellido,
            'ape_paterno' => $apellidos['ape_paterno'],
            'ape_materno' => $apellidos['ape_materno'],
            'fecha_nacimiento' => $this->estudiante->es_nacimiento,
            'edad' => $edad,
            'celular' => $this->estudiante->es_celular,
            'usuario' => $usuario,
            'categoria' => $this->ma_categoria,
            'sede' => $this->sede->se_descripcion,
            'curso' => $this->curso->cu_descripcion,
            'costo' => $this->ma_costo_total,
            'duracion' => $this->ma_duracion_curso,
            'fecha_evaluacion' => $fecha_evaluacion,
            'cancelado' => $this->ma_costo_total - $numero_redondeado,
            'saldo' => $numero_formateado,
            'fecha_inicio' => FechaInicioClases::fechaInicio($this->ma_codigo),
            'detalle' => $detalle,
            'sede_evaluacion' => $this->ma_sede_evaluacion == null ? 'Sin Asignar' : $this->ma_sede_evaluacion,
            'numero_cuotas' => $this->programacion->pg_cuotas,
        ];
    }
}

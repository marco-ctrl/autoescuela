<?php

namespace App\Services;

use App\Models\ItMatricula;
use App\Models\Sede1\Cliente;
use App\Models\Sede1\Evaluacion;
use App\Models\Sede1\Inscripcion;
use App\Models\Sede1\Pago;
use App\Models\Sede2\Cliente as ClienteSede2;
use App\Models\Sede2\Evaluacion as Sede2Evaluacion;
use App\Models\Sede2\Inscripcion as Sede2Inscripcion;
use App\Models\Sede2\Pago as Sede2Pago;
use Carbon\Carbon;
use DateTime;

class Sede1Service
{
    public function verificarMigracion(ItMatricula $matricula, $request)
    {
        $clientes = ClienteSede2::where('ci', $matricula->estudiante->es_documento)
            ->where('fec_nacimiento', $matricula->estudiante->es_nacimiento)
            ->first();

        $fecha = Carbon::parse($matricula->ma_fecha)->format('Y-m-d');
        $fecEvaluacion = Carbon::parse($matricula->ma_fecha_evaluacion)->format('Y-m-d');

        if ($clientes) {
            $inscripcion = Sede2Inscripcion::where('id_cliente', $clientes->id_cliente)
                ->whereDate('fecha', $fecha)
                ->whereDate('fecha_ini', $fecEvaluacion)
                ->where('id_categoria', $matricula->ma_categoria)
                ->first();

            if ($inscripcion) {
                $inscripcion->estado = 'IN';
                $inscripcion->save();

                $evaluacion = Sede2Evaluacion::where('id_inscripcion', $inscripcion->id_inscripcion)->get();
                foreach ($evaluacion as $eval) {
                    $eval->estado = 0;
                    $eval->save();
                }

                $pago = Sede2Pago::where('id_inscripcion', $inscripcion->id_inscripcion)->first();
                $pago->estado = 'IN';
                $pago->save();
            }
        }
    }

    public function updateEvaluacion(ItMatricula $matricula, $request)
    {
        $clientes = Cliente::where('ci', $matricula->estudiante->es_documento)
            ->where('fec_nacimiento', $matricula->estudiante->es_nacimiento)
            ->first();
        if ($clientes == null) {
            return false;
        } else {
            $inscripcion = $this->verificarInscripcion($matricula, $clientes);

            if ($inscripcion) {
                $evaluacion = Evaluacion::where('id_inscripcion', $inscripcion->id_inscripcion)->get();
                $inscripcion->fecha_ini = $request->fecha;
                $inscripcion->fecha_fin = $request->fecha;
                $inscripcion->save();
                foreach ($evaluacion as $eval) {

                    $eval->fecha = $request->fecha;
                    $eval->save();
                }
                return true;
            }

            return false;
        }
    }

    public function migrarMatriculas(ItMatricula $matricula)
    {
        $clientes = Cliente::where('ci', $matricula->estudiante->es_documento)
            ->where('fec_nacimiento', $matricula->estudiante->es_nacimiento)
            ->first();

        if ($clientes == null) {
            $this->procesarMatricula($matricula);

        } else {
            $inscripcion = $this->verificarInscripcion($matricula, $clientes);

            if ($inscripcion == null) {
                $this->procesarMatricula($matricula);
            }
        }
    }

    protected function verificarInscripcion(ItMatricula $matricula, Cliente $cliente, )
    {

        $fecha = Carbon::parse($matricula->ma_fecha)->format('Y-m-d');
        $fecEvaluacion = Carbon::parse($matricula->ma_fecha_evaluacion)->format('Y-m-d');

        $inscripcion = Inscripcion::where('id_cliente', $cliente->id_cliente)
            ->whereDate('fecha', $fecha)
            ->whereDate('fecha_ini', $fecEvaluacion)
            ->where('id_categoria', $matricula->ma_categoria)
            ->where('estado', 'AC')
            ->first();

        if ($inscripcion != null) {
            return $inscripcion;
        } else {
            return null;
        }
    }

    protected function procesarMatricula(ItMatricula $matricula)
    {
        $apellidoCompleto = ltrim($matricula->estudiante->es_apellido);
        $apellidos = explode(" ", $apellidoCompleto);

        if (count($apellidos) >= 2) {
            if ($apellidos[0] == "DE" || $apellidos[0] == "DEL") {
                $apePaterno = $apellidos[0] . " " . $apellidos[1];
                $apeMaterno = implode(" ", array_slice($apellidos, 2)); // Combina las partes restantes en un solo string
                $apeMaterno = ltrim($apeMaterno);
            }
            if ($apellidos[1] == "LA") {
                $apePaterno = $apellidos[0] . " " . $apellidos[1] . " " . $apellidos[2];
                $apeMaterno = implode(" ", array_slice($apellidos, 3)); // Combina las partes restantes en un solo string
                $apeMaterno = ltrim($apeMaterno);
            } else {
                $apePaterno = $apellidos[0];
                $apeMaterno = implode(" ", array_slice($apellidos, 1)); // Combina las partes restantes en un solo string
                $apeMaterno = ltrim($apeMaterno);
            }
        } else {
            $apePaterno = "";
            $apeMaterno = $apellidoCompleto;
        }

        $cod_cliente = self::generarCodigoCliente($matricula, $apePaterno, $apeMaterno);
        if (isset($matricula->estudiante->es_foto) && $matricula->estudiante->es_foto !== "") {
            $decodedImage = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $matricula->estudiante->es_foto));
            $imageName = self::generarNameFoto($matricula->ma_fecha);

            $storagePath = public_path('upload/');
            file_put_contents($storagePath . $imageName, $decodedImage);
            
             $filepath = "/home/bnpupehn/inscripcionlitoral.padbolivia.com/upload/".$imageName;//seg path
            file_put_contents($filepath, $decodedImage);
        } else {
            $imageName = null;
        }

        if (self::verificarCliente($matricula)) {
            Cliente::create([
                'cod_cliente' => $cod_cliente,
                'nombres' => $matricula->estudiante->es_nombre,
                'paterno' => $apePaterno,
                'materno' => $apeMaterno,
                'fec_nacimiento' => $matricula->estudiante->es_nacimiento,
                'sexo' => $matricula->estudiante->es_genero,
                'direccion' => $matricula->estudiante->es_direccion,
                'telefono' => $matricula->estudiante->es_celular,
                'email' => $matricula->estudiante->es_correo,
                'observacion' => $matricula->estudiante->es_observacion,
                'ci' => $matricula->estudiante->es_documento,
                'expedicion' => $matricula->estudiante->es_expedicion,
                'foto' => $imageName,
            ]);
        }

        $clientes = Cliente::where('ci', $matricula->estudiante->es_documento)
            ->where('fec_nacimiento', $matricula->estudiante->es_nacimiento)
            ->first();

        Inscripcion::create([
            'cod_inscripcion' => self::generarCodigoInscripcion(),
            'id_cliente' => $clientes->id_cliente,
            'id_instructor' => 1,
            'id_localidad' => 3,
            'id_curso' => 1,
            'id_categoria' => $matricula->ma_categoria,
            'fecha' => $matricula->ma_fecha,
            'fecha_ini' => $matricula->ma_fecha_evaluacion,
            'fecha_fin' => $matricula->ma_fecha_evaluacion,
            'precio' => $matricula->ma_costo_total,
            'user_ins' => 1,

        ]);

        $inscripcion = Inscripcion::max('id_inscripcion');

        Evaluacion::create([
            'id_inscripcion' => $inscripcion,
            'fecha' => $matricula->ma_fecha_evaluacion,
            'tipo' => 'TEORICA',
            'user_ins' => 1,
        ]);

        $evaluacion = Evaluacion::max('id_evaluacion');

        Evaluacion::create([
            'id_inscripcion' => $inscripcion,
            'fecha' => $matricula->ma_fecha_evaluacion,
            'id_evaluacion_teorica' => $evaluacion,
            'tipo' => 'PRACTICA',
            'user_ins' => 1,
        ]);

        Pago::create([
            'id_inscripcion' => $inscripcion,
            'importe' => $matricula->ma_costo_total,
            'saldo' => 0.00,
            'user_ins' => 1,
            'fecha' => $matricula->ma_fecha,
            'nro_factura' => self::generarNumeroFactura(),
            'nro_recibo' => self::generarNumeroRecibo($matricula->ma_fecha),
            'tipo' => 'CONTADO',
            'estado' => 'AC',
        ]);
    }
    protected function generarNumeroFactura()
    {
        $lastId = Pago::max('nro_factura');

        if (is_null($lastId)) {
            $lastId = 0;
        }

        return $newId = $lastId + 1;
    }

    protected function generarNumeroRecibo($fecha_inscripcion)
    {
        $lastId = Pago::max('id_pago');

        if (is_null($lastId)) {
            $lastId = 0;
        }

        $newId = $lastId + 1;

        $fecha = new DateTime($fecha_inscripcion); // Crear objeto DateTime directamente
        $fecha_abreviada = $fecha->format('mY');

        $newNumeroRecibo = $newId . $fecha_abreviada;

        return $newNumeroRecibo;
    }

    protected function generarCodigoCliente(ItMatricula $matricula, $paterno, $materno)
    {
        $inicialesNombre = strtoupper(substr($matricula->estudiante->es_nombre, 0, 1));
        $apellidoPaterno = strtoupper(substr($paterno, 0, 1));
        $apellidoMaterno = strtoupper(substr($materno, 0, 1));

        $fechaNacimiento = new DateTime($matricula->estudiante->es_nacimiento);
        $anoNacimiento = $fechaNacimiento->format('y');
        $mesNacimiento = $fechaNacimiento->format('m');
        $diaNacimiento = $fechaNacimiento->format('d');

        $codigoCliente = $anoNacimiento . $mesNacimiento . $diaNacimiento . '-' . $inicialesNombre . $apellidoPaterno . $apellidoMaterno;

        return $codigoCliente;
    }

    protected function generarCodigoInscripcion()
    {
        $lastId = Inscripcion::max('id_inscripcion');

        if (is_null($lastId)) {
            $lastId = 0;
        }

        $newId = $lastId + 1;
        $currentDate = Carbon::now();

        Carbon::setLocale('es');

        $shortMonthName = $currentDate->shortMonthName;
        $newCode = strtoupper($shortMonthName) . "-" . str_pad($newId, 5, "0", STR_PAD_LEFT);

        return $newCode;
    }

    protected function verificarCliente(ItMatricula $matricula)
    {
        $clientes = Cliente::where('ci', $matricula->estudiante->es_documento)
            ->where('fec_nacimiento', $matricula->estudiante->es_nacimiento)
            ->first();
        if ($clientes == null) {
            return true;
        } else {
            return false;
        }
    }

    protected function generarNameFoto($fecha_inscripcion)
    {

        $lastId = Cliente::max('id_cliente');
        if (is_null($lastId)) {
            $lastId = 0;
        }

        $fecha = new DateTime($fecha_inscripcion); // Crear objeto DateTime directamente
        $fecha_abreviada = $fecha->format('ymd');

        $newId = $lastId + 1;
        $newNameFoto = $newId . "_" . $fecha_abreviada . ".jpg";

        return $newNameFoto;
    }

}

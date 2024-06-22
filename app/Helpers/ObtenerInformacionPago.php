<?php

namespace App\Helpers;

use App\Models\ItCuota;
use App\Models\ItEstudiante;
use App\Models\ItMatricula;
use App\Models\ItSerie;

class ObtenerInformacionPago
{
    public static function obtenerInformacionPago(int $codigo, ItCuota $cuota, string $tipoDocumento): string
    {
        $matricula = ItMatricula::with('estudiante', 'curso')->where('ma_codigo', $codigo)->first();
        $serie = ItSerie::where('sr_codigo', 1)->first();

        $data = [
            "emisionpago" => $cuota->ct_created,
            "descripcion" => $matricula->curso->cu_descripcion . '/' . "CUOTA N¡Æ-" . $cuota->ct_numero,
            "fechacuota" => $cuota->ct_fecha_pago,
            "documentoes" => $matricula->estudiante->es_documento,
            "estudiante" => $matricula->estudiante->es_nombre . ' ' . $matricula->estudiante->es_apellido,
            "pago" => $cuota->ct_importe,
            "monto" => $cuota->ct_importe,
            "serie" => $serie->sr_descripcion,
            "correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos(),
            "tipo" => $tipoDocumento
        ];
        
        // Convertir a JSON
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        
        // Convertir JSON en string con las barras invertidas escapadas
        $string = addslashes($json);
        
        return $json;
    }

    public static function obtenerInformacionPagoCertificado(ItEstudiante $estudiante, ItCuota $cuota, string $tipoDocumento, string $descripcion): string
    {
        $serie = ItSerie::where('sr_codigo', 1)->first();

        $data = [
            "emisionpago" => $cuota->ct_created,
            "descripcion" =>   'PAGO ' . $descripcion . '/' . "CUOTA N°-" . $cuota->ct_numero,
            "fechacuota" => $cuota->ct_fecha_pago,
            "documentoes" => $estudiante->es_documento,
            "estudiante" => $estudiante->es_nombre . ' ' . $estudiante->es_apellido,
            "pago" => $cuota->ct_importe,
            "monto" => $cuota->ct_importe,
            "serie" => $serie->sr_descripcion,
            "correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos(),
            "tipo" => $tipoDocumento
        ];
        
        //dd($data);
        
        // Convertir a JSON
        //$json = json_encode($data, JSON_UNESCAPED_UNICODE);
        $json = json_encode($data);
        // Convertir JSON en string con las barras invertidas escapadas
        $string = addslashes($json);
        dd($json);
        return $json;
    }

    public static function obtenerInformacionPagoHoraExtra(int $codigo, ItCuota $cuota, string $tipoDocumento): string
    {
        $matricula = ItMatricula::with('estudiante', 'curso')->where('ma_codigo', $codigo)->first();
        $serie = ItSerie::where('sr_codigo', 1)->first();

        $data = [
            "emisionpago" => $cuota->ct_created,
            "descripcion" => 'HORAS EXTRA | ' . $matricula->curso->cu_descripcion . '/' . "CUOTA N¡Æ-" . $cuota->ct_numero,
            "fechacuota" => $cuota->ct_fecha_pago,
            "documentoes" => $matricula->estudiante->es_documento,
            "estudiante" => $matricula->estudiante->es_nombre . ' ' . $matricula->estudiante->es_apellido,
            "pago" => $cuota->ct_importe,
            "monto" => $cuota->ct_importe,
            "serie" => $serie->sr_descripcion,
            "correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos(),
            "tipo" => $tipoDocumento
        ];
        
        // Convertir a JSON
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        
        // Convertir JSON en string con las barras invertidas escapadas
        $string = addslashes($json);
        
        return $json;
    }

    public static function obtenerInformacionPagoEvaluacion(int $codigo, ItCuota $cuota, string $tipoDocumento): string
    {
        $matricula = ItMatricula::with('estudiante', 'curso')->where('ma_codigo', $codigo)->first();
        $serie = ItSerie::where('sr_codigo', 1)->first();

        $data = [
            "emisionpago" => $cuota->ct_created,
            "descripcion" => 'EVALUACION AGREGADA | ' . $matricula->curso->cu_descripcion . '/' . "CUOTA N¡Æ-" . $cuota->ct_numero,
            "fechacuota" => $cuota->ct_fecha_pago,
            "documentoes" => $matricula->estudiante->es_documento,
            "estudiante" => $matricula->estudiante->es_nombre . ' ' . $matricula->estudiante->es_apellido,
            "pago" => $cuota->ct_importe,
            "monto" => $cuota->ct_importe,
            "serie" => $serie->sr_descripcion,
            "correlativo" => ObtenerCorrelativo::obtenerCorrelativoIngresos(),
            "tipo" => $tipoDocumento
        ];
        
        // Convertir a JSON
        $json = json_encode($data, JSON_UNESCAPED_UNICODE);
        
        // Convertir JSON en string con las barras invertidas escapadas
        $string = addslashes($json);
        
        return $json;
    }
}
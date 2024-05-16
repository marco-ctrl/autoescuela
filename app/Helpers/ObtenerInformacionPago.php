<?php

namespace App\Helpers;

use App\Models\ItCuota;
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
            "descripcion" => $matricula->curso->cu_descripcion . '/' . "CUOTA N°-" . $cuota->ct_numero,
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
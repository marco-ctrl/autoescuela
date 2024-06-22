<?php

namespace Src\manager\matricula\infrastructure\controllers;

use App\Helpers\CalcularSaldo;
use App\Http\Controllers\Controller;
use App\Models\ItMatricula;
use App\Models\ItSede;
use App\Services\Sede1Service;
use App\Services\Sede2Service;
use Illuminate\Http\JsonResponse;
use Src\manager\matricula\infrastructure\validators\UpdateEvaluacionValidatorRequest;
use Symfony\Component\HttpFoundation\Response;

final class UpdateEvaluacionPUTController extends Controller
{
    protected $sede1;
    protected $sede2;

    public function __construct(
        Sede1Service $sede1,
        Sede2Service $sede2
    ) {
        $this->sede1 = $sede1;
        $this->sede2 = $sede2;
    }

    public function index(ItMatricula $matricula, UpdateEvaluacionValidatorRequest $request): JsonResponse
    {
        try {
            $matriculas = ItMatricula::find($matricula->ma_codigo);
            /*$saldo = CalcularSaldo::calcular($matriculas->ma_codigo);

            if ($saldo > 0) {
                return response()->json([
                    'status' => false,
                    'message' => __('No se puede registrar la evaluacion porque el alumno tiene saldo pendiente'),
                ], Response::HTTP_OK);
            }*/

            $sede = ItSede::where('se_descripcion', $request->sede)
                ->first('se_codigo');

            if ($sede->se_codigo == 1) {
                $this->sede1->verificarMigracion($matriculas, $request);
                $update = $this->sede1->updateEvaluacion($matriculas, $request);
            }
            if ($sede->se_codigo == 2) {
                $this->sede2->verificarMigracion($matriculas, $request);
                $this->sede2->migrarMatriculas($matriculas);
            }

            $matriculas->ma_fecha_evaluacion = $request->fecha;
            $matriculas->ma_sede_evaluacion = $request->sede;
            $matriculas->save();

            if ($sede->se_codigo == 1) {
                if (!$update) {
                    $this->sede1->migrarMatriculas($matriculas);
                }
            }
            if ($sede->se_codigo == 2) {
                $this->sede2->migrarMatriculas($matriculas);
            }

            return response()->json([
                'status' => true,
                'data' => $matriculas,
                'message' => __('Fecha de evaluacion registrada correctamente'),
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to save evaluacion'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

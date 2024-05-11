<?php

namespace Src\admin\matricula\infrastructure\controllers;

use Src\admin\matricula\infrastructure\validators\UpdateEvaluacionValidatorRequest;
use App\Http\Controllers\Controller;
use App\Models\ItMatricula;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UpdateEvaluacionPUTController extends Controller
{
    public function index(ItMatricula $matricula, UpdateEvaluacionValidatorRequest $request): JsonResponse
    {
        try{
            $matriculas = ItMatricula::find($matricula->ma_codigo)
                ->update([
                    'ma_fecha_evaluacion' => $request->fecha,
                    'ma_sede_evaluacion' => $request->sede,
                ]);

            return response()->json([
                'status' => true,
                'data' => $matriculas,
                'message' => __('Fecha de evaluacion registrada correctamente')
            ], Response::HTTP_OK);
        }
        catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to save evaluacion'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
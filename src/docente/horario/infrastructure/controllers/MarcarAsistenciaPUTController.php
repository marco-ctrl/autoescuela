<?php
namespace Src\docente\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItHorarioMatricula;
use DateTime;
use Illuminate\Http\JsonResponse;
use Src\docente\horario\infrastructure\validators\MarcarAsistenciaPUTRequest;
use Symfony\Component\HttpFoundation\Response;

final class MarcarAsistenciaPUTController extends Controller
{
    public function index(MarcarAsistenciaPUTRequest $request, ItHorarioMatricula $horario): JsonResponse
    {
        try {
            $horarioMatricula = ItHorarioMatricula::find($horario->hm_codigo);

            $fechaHoraActual = new DateTime();
            $fechaHoraComparar = new DateTime($horarioMatricula->hm_fecha_inicio);

            if ($fechaHoraComparar > $fechaHoraActual) {
                return response()->json([
                    'status' => false,
                    'message' => __('No se puede marcar asistencia porque el horario aun no comienza'),
                ], Response::HTTP_OK);    
            }

            $horarioMatricula = ItHorarioMatricula::find($horario->hm_codigo)
                ->update([
                    'hm_asistencia' => $request->asistencia,
                    'ma_observacion_asistencia' => $request->observacion,
                    'hm_justificacion' => $request->justificacion,
                ]);

            return response()->json([
                'status' => true,
                'message' => __('Se marco asistencia correctamente'),
                'data' => $horarioMatricula,
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('error al marcar asistencia'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

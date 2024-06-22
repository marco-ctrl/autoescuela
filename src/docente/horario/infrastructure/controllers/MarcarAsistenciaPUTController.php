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
            $fechaHoraCompararInicio = new DateTime($horarioMatricula->hm_fecha_inicio);
            $fechaHoraCompararFin = new DateTime($horarioMatricula->hm_fecha_final);

            // Validar que la fecha y hora actual se encuentre entre el horario de inicio y fin
            
            if ($fechaHoraCompararInicio > $fechaHoraActual) {
                return response()->json([
                    'status' => false,
                    'message' => __('No se puede marcar asistencia porque el horario aun no comienza'),
                ], Response::HTTP_OK);    
            }

            if(auth()->user()->us_tipo != 3)
            {
                if ($fechaHoraCompararFin < $fechaHoraActual) {
                    return response()->json([
                        'status' => false,
                        'message' => __('No se puede marcar asistencia porque el horario ya finalizo'),
                    ], Response::HTTP_OK);    
                }   
            }

            $horarioMatricula = ItHorarioMatricula::find($horario->hm_codigo)
                ->update([
                    'hm_tema' => strtoupper($request->tema),
                    'hm_nota' => $request->nota,
                    'hm_asistencia' => $request->asistencia,
                    'ma_observacion_asistencia' => strtoupper($request->observacion),
                    'hm_justificacion' => strtoupper($request->justificacion),
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

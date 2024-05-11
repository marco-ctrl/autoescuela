<?php

namespace Src\admin\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItHorarioMatricula;
use App\Models\ItMatricula;
use App\Helpers\actualizarNumeroHorario;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Src\admin\horario\infrastructure\validators\StoreHorarioValidatorRequest;
use Symfony\Component\HttpFoundation\Response;
use DateTime;

final class StoreHorarioMatriculaPostController extends Controller
{

    public function index(StoreHorarioValidatorRequest $request): JsonResponse
    {
        try {
            $fechaHoraActual = new DateTime();
            $fechaHoraComparar = new DateTime($request->hm_fecha_inicio);

            /*if ($fechaHoraComparar < $fechaHoraActual) {
                return response()->json([
                    'status' => false,
                    'message' => __('No se puede agregar una fecha anterior a la fecha actual'),
                ], Response::HTTP_OK);    
            }*/

            $fechaInicio = Carbon::parse($request->hm_fecha_inicio);
            $fechaFinal = $fechaInicio->addHour();
            $matricula = ItMatricula::find($request->ma_codigo);
        
            $horaOcupada = ItHorarioMatricula::where('do_codigo', $request->do_codigo)
                ->where('hm_fecha_inicio', $request->hm_fecha_inicio)->first();

            if ($horaOcupada) {
                return response()->json([
                    'status' => false,
                    'message' => __('Este docente ya tiene esta hora ocupada'),
                ], Response::HTTP_OK);
            }

            $hmNumero = ItHorarioMatricula::where('ma_codigo', $request->ma_codigo)
                ->count();

            if (!$hmNumero) {
                $hmNumero = 1;
            } else {
                $hmNumero++;
            }
            
            if ($hmNumero > $matricula->ma_duracion_curso) {
                return response()->json([
                    'status' => false,
                    'numero' => $hmNumero,
                    'message' => __('No puede crear mas horarios'),
                ], Response::HTTP_OK);
            }

            $horarioMatricula = ItHorarioMatricula::create([
                'hm_fecha_inicio' => $request->hm_fecha_inicio,
                'hm_fecha_final' => $fechaFinal->format('Y-m-d H:i:s'),
                'hm_color' => $request->hm_color,
                'ma_codigo' => $request->ma_codigo,
                'do_codigo' => $request->do_codigo,
                'hm_numero' => $hmNumero,
            ]);

            actualizarNumeroHorario::actualizar($request->ma_codigo);
            
            return response()->json([
                'status' => true,
                'message' => __('horario creado exitosamente'),
                'data' => $horarioMatricula,
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to created the horario'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }
}

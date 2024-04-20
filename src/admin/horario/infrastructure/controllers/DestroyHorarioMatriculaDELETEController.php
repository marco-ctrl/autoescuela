<?php

namespace Src\admin\horario\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItHorarioMatricula;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class DestroyHorarioMatriculaDELETEController extends Controller
{
    public function index(ItHorarioMatricula $horario): JsonResponse
    {
        try {
            $horarioMatriculas = ItHorarioMatricula::find($horario->hm_codigo)->delete();
                
            return response()->json([
                'status' => true,
                'message' => 'horario eliminado correctamente',
            ], Response::HTTP_OK);
            
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to delete horarios'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
<?php

namespace Src\manager\matricula\infrastructure\controllers;

use App\Helpers\CalcularEdad;
use App\Http\Controllers\Controller;
use App\Models\ItCategoriaAmbiente;
use App\Models\ItMatricula;
use App\Models\ItSede;
use Src\manager\matricula\infrastructure\validators\UpdateMatriculaRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class UpdateMatriculaPUTController extends Controller
{
    public function index(ItMatricula $matricula, UpdateMatriculaRequest $request):JsonResponse
    {
        try{
            $sede = ItSede::where('se_descripcion', $request->se_codigo)->first();

            $matricula->ma_categoria = $request->ma_categoria;
            $matricula->se_codigo = $sede->se_codigo;
            $matricula->save();

            return response()->json([
                'message' => 'Matricula actualizada correctamente',
                'status' => true
            ], Response::HTTP_OK);
        }
        catch(\Exception $e){
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Error al actualizar la matricula',
                'status' => false
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
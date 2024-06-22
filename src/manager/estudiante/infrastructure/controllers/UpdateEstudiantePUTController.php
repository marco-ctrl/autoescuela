<?php

namespace Src\manager\estudiante\infrastructure\controllers;

use App\Events\UsuarioCreadoEvent;
use App\Http\Controllers\Controller;
use App\Models\ItEstudiante;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\GeneratePassword;
use App\Listeners\CredencialUsuarioListener;
use App\Models\User;
use Src\manager\estudiante\infrastructure\resources\ListAllEstudianteResource;
use Src\manager\estudiante\infrastructure\validators\UpdateEstudianteRequest;

final class UpdateEstudiantePUTController extends Controller
{
    public function index(UpdateEstudianteRequest $request, ItEstudiante $estudiante): JsonResponse
    {
        try {
            $correo = $request->es_correo;
            
            if($correo == '')
            {
                $num = $estudiante->es_codigo;
                $correo = $request->es_nombre;
                $correo = str_replace(" ", "", $correo);
                $correo = strtolower($correo);
                $correo = $correo . $num . "@autoescuela.com";
            }
            
            $usuario = User::where('us_codigo', $estudiante->us_codigo)->first();
            $usuario->us_correo = $correo;
            $usuario->us_estado = 1;
            $usuario->save();

            //dd($usuario);

            if(!$usuario){
                return response()->json([
                    'status' => false,
                    'message' => 'Error al modificar el usuario',
                    'usuario' => $usuario
                ], Response::HTTP_BAD_REQUEST);
            }

            $estudianteEditado = ItEstudiante::find($estudiante->es_codigo)
            ->update([
                'es_documento' => $request->es_documento,
                'es_expedicion' => strtoupper($request->es_expedicion),
                'es_nombre' => strtoupper($request->es_nombre),
                'es_apellido' => strtoupper($request->ape_paterno) . ' ' . strtoupper($request->ape_materno),
                'es_correo' => $correo,
                'es_nacimiento' => $request->es_nacimiento,
                'es_genero' => $request->es_genero,
                'es_celular' => $request->es_celular,
                'es_direccion' => strtoupper($request->es_direccion),
                'es_foto' => $request->es_foto,
                'es_tipodocumento' => $request->es_tipodocumento,
                'es_estado' => 1,
                'es_observacion' => $request->es_observacion,
                'us_codigo_create' => auth()->user()->us_codigo,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('Estudiante modificado exitosamente'),
                'data' => $estudianteEditado,
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to update the estudiante'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

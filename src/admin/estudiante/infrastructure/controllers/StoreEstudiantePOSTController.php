<?php

namespace Src\admin\estudiante\infrastructure\controllers;

use App\Events\UsuarioCreadoEvent;
use App\Http\Controllers\Controller;
use App\Models\ItEstudiante;
use Illuminate\Http\JsonResponse;
use Src\admin\estudiante\infrastructure\validators\StoreEstudianteRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Helpers\GeneratePassword;
use App\Listeners\CredencialUsuarioListener;
use App\Models\User;
use Src\admin\estudiante\infrastructure\resources\ListAllEstudianteResource;

final class StoreEstudiantePOSTController extends Controller
{
    public function index(StoreEstudianteRequest $request): JsonResponse
    {
        try {
            $correo = $request->es_correo;
            $password = GeneratePassword::generatePassword();
            
            if($request->es_correo == '')
            {
                $num = ItEstudiante::max('es_codigo') + 1;
                $correo = $request->es_nombre;
                $correo = str_replace(" ", "", $correo);
                $correo = strtolower($correo);
                $correo = $correo . $num . "@autoescuela.com";
            }
            
            $usuario = User::create([
                'us_tipo' => 0,
                'us_correo' => $correo,
                'us_password' => bcrypt($password),
                'us_estado' => 1,
                'us_created' => now()->format('Y-m-d H:i:s'),
            ]);

            if(!$usuario){
                return response()->json([
                    'status' => false,
                    'message' => 'Error al crear el usuario'
                ], Response::HTTP_BAD_REQUEST);
            }

            $apellido = strtoupper($request->ape_paterno) . ' ' . strtoupper($request->ape_materno);

            $estudiante = ItEstudiante::create([
                'es_documento' => $request->es_documento,
                'es_expedicion' => strtoupper($request->es_expedicion),
                'es_nombre' => strtoupper($request->es_nombre),
                'es_apellido' => trim($apellido),
                'es_correo' => $correo,
                'es_nacimiento' => $request->es_nacimiento,
                'es_genero' => $request->es_genero,
                'es_celular' => $request->es_celular,
                'es_direccion' => strtoupper($request->es_direccion),
                'es_foto' => $request->es_foto,
                'es_tipodocumento' => $request->es_tipodocumento,
                'es_estado' => 1,
                'us_codigo' => $usuario->us_codigo,
                'es_created' => now()->format('Y-m-d h:m:s'),
                'es_observacion' => $request->es_observacion,
                'us_codigo_create' => auth()->user()->us_codigo,
            ]);

            return response()->json([
                'status' => true,
                'message' => __('Estudiante agregado exitosamente'),
                'data' => new ListAllEstudianteResource($estudiante),
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to created the estudiante'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function loginUser(Request $request): JsonResponse
    {
        try {
            //Aquí se busca el usuario por email
            $user = User::where('us_correo', $request->us_correo)->first();

            //Se Verifica si el usuario existe y la contraseña es correcta
            if (!$user || !Hash::check($request->us_password, $user->us_password)) {
                return response()->json([
                    'status' => false,
                    'message' => __('Invalid credentials')
                ], Response::HTTP_UNAUTHORIZED);
            }

            //Aquí se genera el token de autenticación para el usuario
            $token = $user->createToken('API Token')->plainTextToken;

            if($user->us_tipo == 0){
                $usuario = User::with('estudiante')->where('us_codigo', $user->us_codigo)->first();
            }

            if($user->us_tipo == 1){
                $usuario = User::with('docente')->where('us_codigo', $user->us_codigo)->first();
            }

            if($user->us_tipo == 2 || $user->us_tipo == 3){
                $usuario = User::with('trabajador')->where('us_codigo', $user->us_codigo)->first();
            }

            return response()->json([
                'status' => true,
                'message' => __('User logged in successfully'),
                'token' => $token,
                'user' => $usuario,
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to login user'),
                'error' => $ex->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logoutUser(Request $request): JsonResponse
    {
        try {
            $request->user()->tokens()->delete(); // Elimina todos los tokens del usuario al cerrar la sesión

            return response()->json([
                'status' => true,
                'message' => __('User logged out successfully')
            ], Response::HTTP_OK);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to logout user'),
                'error' => $ex->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

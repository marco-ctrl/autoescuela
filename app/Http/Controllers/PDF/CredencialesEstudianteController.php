<?php

namespace App\Http\Controllers\PDF;

use App\Http\Controllers\Controller;
use App\Models\ItEstudiante;
use App\Models\User;
use App\Helpers\GeneratePassword;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class CredencialesEstudianteController extends Controller
{
    public function generarCredenciales(ItEstudiante $estudiante, User $usuario){
       /* $token = PersonalAccessToken::where('tokenable_id', $usuario->us_codigo)->first();
        $usuario = User::find($token->tokenable_id);
        
        if(!$usuario)
        {
            return redirect()->route('login');
        }*/

        $password = GeneratePassword::generatePassword();

        $user = User::find($estudiante->us_codigo);
        $user->us_password = bcrypt($password);
        $user->save();

        $pass = ['password' => $password];
        //dd($pass);

        $pdf = PDF::setPaper('A5', 'portrait')
        ->loadView('pdf.estudiante.estudiante-password', compact('user', 'estudiante', 'pass'));
        return $pdf->stream('kardex.pdf');
    }
}

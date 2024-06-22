<?php

namespace App\Http\Controllers\PDF\Docente;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ReporteAsistenciaController extends Controller
{
    public function index(User $usuario, Request $request)
    {
        $docente = $usuario->docente;
        // dd($docente);
        return view('pdf.docente.asistencia', compact('docente'));
    }
}

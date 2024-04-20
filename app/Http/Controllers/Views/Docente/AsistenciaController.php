<?php

namespace App\Http\Controllers\Views\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index(){
        return view('docente.asistencia.index');
    }
}

<?php

namespace App\Http\Controllers\Views\Estudiante;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HorarioController extends Controller
{
    public function index()
    {
        return view('estudiante.horario.index');
    }
}

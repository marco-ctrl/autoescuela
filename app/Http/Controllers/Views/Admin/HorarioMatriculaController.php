<?php

namespace App\Http\Controllers\Views\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItMatricula;
use Illuminate\Http\Request;

class HorarioMatriculaController extends Controller
{
    public function index(ItMatricula $matricula)
    {
        $matricula = ItMatricula::with('estudiante')->find($matricula->ma_codigo);

        return view('admin.horario-matricula.index', compact('matricula')); 
    }
}

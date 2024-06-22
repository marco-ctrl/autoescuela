<?php

namespace App\Http\Controllers\Views\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        return view('manager.estudiante.index');
    }

    public function create()
    {
        return view('manager.estudiante.create');
    }
}

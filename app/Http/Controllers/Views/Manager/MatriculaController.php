<?php

namespace App\Http\Controllers\Views\Manager;

use App\Http\Controllers\Controller;

class MatriculaController extends Controller
{
    public function index()
    {
        return view('manager.matricula.index');
    }

    public function create()
    {
        return view('manager.matricula.create');
    }
}

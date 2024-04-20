<?php

namespace App\Http\Controllers\Views\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstudianteController extends Controller
{
    public function index()
    {
        return view('admin.estudiante.index');
    }

    public function create()
    {
        return view('admin.estudiante.create');
    }
}

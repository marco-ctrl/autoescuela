<?php

namespace App\Http\Controllers\Views\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\MatriculaResource;
use App\Models\ItMatricula;

class MatriculaController extends Controller
{
    public function index()
    {
        return view('admin.matricula.index');
    }

    public function create()
    {
        return view('admin.matricula.create');
    }
}

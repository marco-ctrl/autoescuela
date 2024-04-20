<?php

namespace App\Http\Controllers\Views\Docente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('docente.index');
    }
}

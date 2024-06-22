<?php

namespace App\Http\Controllers\Views\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItServicio;
use Illuminate\Http\Request;

class ServicioController extends Controller
{
    public function index()
    {
        $servicio = ItServicio::first();
        $servicios = ItServicio::where('sv_estado', 1)->get();
        return view('admin.servicio.index', compact('servicio', 'servicios'));
    }

    public function create()
    {
        return view('admin.servicio.servicios');
    }
}

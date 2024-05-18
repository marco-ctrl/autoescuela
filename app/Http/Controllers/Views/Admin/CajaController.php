<?php

namespace App\Http\Controllers\Views\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\docente\PagoDocenteResource;
use App\Models\ItDocente;
use App\Models\ItHorarioMatricula;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    
    public function pagos()
    {
        return view('admin.caja.pagos');
    }

    public function pagoDocentes()
    {
        return view('admin.caja.pagar-docente');
    }

    public function ingresos()
    {
        return view('admin.caja.ingresos');
    }
}

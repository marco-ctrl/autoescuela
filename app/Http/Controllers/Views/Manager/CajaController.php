<?php

namespace App\Http\Controllers\Views\Manager;

use App\Http\Controllers\Controller;

class CajaController extends Controller
{
    
    public function pagos()
    {
        return view('manager.caja.pagos');
    }

    public function pagoDocentes()
    {
        return view('manager.caja.pagar-docente');
    }

    public function ingresos()
    {
        return view('manager.caja.ingresos');
    }

    public function gastos() {
        return view('manager.caja.gastos');
    }
}

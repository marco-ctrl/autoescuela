<?php

namespace App\Http\Controllers\Views\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CajaController extends Controller
{
    
    public function pagos()
    {
        return view('admin.caja.pagos');
    }
}

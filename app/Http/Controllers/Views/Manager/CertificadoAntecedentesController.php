<?php

namespace App\Http\Controllers\Views\Manager;

use App\Http\Controllers\Controller;
use App\Models\ItCertificadoAntecedentes;
use Illuminate\Http\Request;

class CertificadoAntecedentesController extends Controller
{
    public function index()
    {
        $certificado = ItCertificadoAntecedentes::first();
        return view('manager.certificado-antecedentes.index', compact('certificado'));
    }
}

<?php

namespace App\Http\Controllers\PDF\Caja;

use App\Http\Controllers\Controller;
use App\Models\ItInstitucion;
use App\Models\ItPagoDocente;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PagarDocenteController extends Controller
{
    
    public function index(ItPagoDocente $pagoDocente)
    {
        $institucion = ItInstitucion::first();
        $pdf = Pdf::setPaper('A4', 'portrait')
        ->loadView('pdf.caja.pagar-docente',
        compact('pagoDocente', 'institucion')
        );
        return $pdf->stream('pagar-docente.pdf');
    }

    public function ticket(ItPagoDocente $pagoDocente)
    {
        $institucion = ItInstitucion::first();
        $pdf = Pdf::setPaper([0,-15,226.772456,300], 'portrait');
        $pdf->setOption(['margin_left' => 0,
                        'margin_right' => 0,
                        'margin_top' => 0,
                        'margin_bottom' => 0,
                        ])
        ->loadView('pdf.caja.pagar-docente-ticket',
        compact('pagoDocente', 'institucion')
        );
        return $pdf->stream('pagar-docente.pdf');
    }
}

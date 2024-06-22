<?php

namespace App\Http\Controllers\PDF\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use App\Models\ItInstitucion;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class ComprobanteEgresosController extends Controller
{
    public function generarComprobantePdf(ItComprobantePago $comprobante, User $user, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();

        if (!$token) {
            return Response::HTTP_UNAUTHORIZED;
        }
        $usuario = User::find($token->tokenable_id);

        $institucion = ItInstitucion::first();
        $informacion = json_decode($comprobante->cp_informacion);

        $pdf = Pdf::setPaper('A4', 'portrait')
            ->loadView('pdf.comprobante-egreso',
                compact('usuario', 'informacion', 'institucion', 'comprobante')
            );
        return $pdf->stream('comprobante' . $comprobante->cp_codigo . '.pdf');
    }

    public function generarComprobanteTicketPdf(ItComprobantePago $comprobante, User $user, Request $request, float $height)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();
        if (!$token) {
            return Response::HTTP_UNAUTHORIZED; // 401
        }
        $usuario = User::find($token->tokenable_id);

        $institucion = ItInstitucion::first();
        $informacion = json_decode($comprobante->cp_informacion);
        $height = $height * 3.3;

        $pdf = Pdf::setPaper([0, 0, 226.772, $height], 'portrait')
            ->loadView('pdf.comprobante-egreso-ticket',
                compact('usuario', 'informacion', 'institucion', 'comprobante')
            );
        return $pdf->stream('comprobante' . $comprobante->cp_codigo . '.pdf');

    }

    public function render(ItComprobantePago $comprobante, User $user, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();

        if (!$token) {
            return Response::HTTP_UNAUTHORIZED;
        }
        $usuario = User::find($token->tokenable_id);

        $institucion = ItInstitucion::first();
        $informacion = json_decode($comprobante->cp_informacion);
        
        return view('pdf.comprobante-egreso-ticket',
            compact('usuario', 'informacion', 'institucion', 'comprobante')
        );
    }

}

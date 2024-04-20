<?php

namespace App\Listeners;

use App\Events\UsuarioCreadoEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Barryvdh\DomPDF\Facade\Pdf;

class CredencialUsuarioListener
{
    public function __construct() {}

    public function handle(UsuarioCreadoEvent $event)
    {
        $estudiante = $event->estudiante;
        $password = $event->password;
        $rol = $event->rol;
        //dd($password);

        // Generar el contenido del PDF (por ejemplo, usando una vista)
        $pdf = PDF::loadView('pdf.estudiante', compact('estudiante', 'password', 'rol'));

        // Descargar el PDF
        return $pdf->download('estudiante_'.$estudiante->es_codigo.'.pdf');
    }
}

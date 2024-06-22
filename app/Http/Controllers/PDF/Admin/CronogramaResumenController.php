<?php

namespace App\Http\Controllers\PDF\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\PDF\Admin\CronogramaResumenResource;
use App\Models\ItHorarioMatricula;
use App\Models\ItInstitucion;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Symfony\Component\HttpFoundation\Response;

class CronogramaResumenController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
        try {

            $cronograma = $this->getCronograma($request);

            return response()->json([
                'data' => CronogramaResumenResource::collection($cronograma),
                'message' => 'Cronograma resumen',
                'status' => true,
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Error al procesar la solicitud',
                'status' => false,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function generarPdf(Request $request)
    {
        if(auth()->user() === null){
            $token = PersonalAccessToken::where('tokenable_id', $request->usuario)->first();

            if (!$token) {
                return Response::HTTP_UNAUTHORIZED;
            }
            $usuario = User::find($token->tokenable_id);
        }
        else{
            $usuario = auth()->user();
        }

        $fechas = [
            'desde' => $request->fechaInicial,
            'hasta' => $request->fechaFinal,
        ];

        $cronogramas = $this->getCronograma($request);
        
        $cronograma = CronogramaResumenResource::collection($cronogramas);
        $cronogramas = $cronograma->toArray($request);

        $institucion = ItInstitucion::first();

        $data = [
            'title' => 'Mi primer PDF generado con Laravel y DOMPDF',
            'date' => date('m/d/Y'),
            // cualquier otro dato que quieras pasar a la vista
        ];
        
        $pdf = Pdf::setPaper('legal', 'landscape')
        ->loadView('pdf.cronograma-resumen',
            compact('cronogramas', 'institucion', 
                    'usuario', 'data'));
        return $pdf->stream('cronograma_resumen.pdf');
    }

    private function getCronograma($request)
    {
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;

        return ItHorarioMatricula::whereDate('hm_fecha_inicio', '>=', $fechaInicial)
            ->whereDate('hm_fecha_inicio', '<=', $fechaFinal)
            ->orderBy('hm_fecha_inicio', 'asc')
            ->get();
    }
}

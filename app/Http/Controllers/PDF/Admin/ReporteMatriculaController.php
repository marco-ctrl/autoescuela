<?php

namespace App\Http\Controllers\PDF\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItInstitucion;
use App\Models\ItMatricula;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Src\admin\matricula\infrastructure\resources\ListAllMatriculaResource;
use Symfony\Component\HttpFoundation\Response;

class ReporteMatriculaController extends Controller
{
    //
    public function index(Request $request): JsonResponse
    {
        try {

            $matriculados = $this->getMatriculados($request);

            return response()->json([
                'data' => ListAllMatriculaResource::collection($matriculados),
                'message' => 'listar matriculados',
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

        $matriculados = $this->getMatriculados($request);
        
        $matricula = ListAllMatriculaResource::collection($matriculados);
        $matriculados = $matricula->toArray($request);

        $institucion = ItInstitucion::first();

        $data = [
            'title' => 'Mi primer PDF generado con Laravel y DOMPDF',
            'date' => date('m/d/Y'),
            // cualquier otro dato que quieras pasar a la vista
        ];
        
        $pdf = Pdf::setPaper('letter', 'landscape')
        ->loadView('pdf.reporte-matriculados',
            compact('matriculados', 'institucion', 
                    'usuario', 'data'));
        return $pdf->stream('reporte_matriculados.pdf');
    }

    private function getMatriculados($request)
    {
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;
        $usuario = $request->usuario;

        return ItMatricula::whereDate('ma_fecha', '>=', $fechaInicial)
            ->whereDate('ma_fecha', '<=', $fechaFinal)
            ->where('us_codigo_create', 'LIKE', '%'.$usuario.'%')
            ->orderBy('ma_fecha', 'asc')
            ->get();
    }
}

<?php

namespace App\Http\Controllers\PDF\Admin;

use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use App\Models\ItInstitucion;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Src\admin\caja\infrastructure\resources\ListGetAllEgresosGETResources;
use Src\admin\caja\infrastructure\resources\ListGetAllIngresosGETResources;
use Symfony\Component\HttpFoundation\Response;

class ResumenIngresosEgresosController extends Controller
{
    public function index(Request $request)
    {
        try {
            $ingresos = $this->getIngresos($request);
            $egresos = $this->getEgresos($request);

            return response()->json([
                'status' => true,
                'ingreso' => ListGetAllIngresosGETResources::collection($ingresos),
                'egreso' => ListGetAllEgresosGETResources::collection($egresos),
                'resumen' => $this->getResumen($request, $ingresos, $egresos),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('error al cargar datos'),
                'error' => $e->getMessage(),
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

        $ingresos = $this->getIngresos($request);
        $egresos = $this->getEgresos($request);
        $resumen = $this->getResumen($request, $ingresos, $egresos);

        $ingreso = ListGetAllIngresosGETResources::collection($ingresos);
        $egreso = ListGetAllEgresosGETResources::collection($egresos);

        $ingresos = $ingreso->toArray($request);
        $egresos = $egreso->toArray($request);

        $institucion = ItInstitucion::first();

        $data = [
            'title' => 'Mi primer PDF generado con Laravel y DOMPDF',
            'date' => date('m/d/Y'),
            // cualquier otro dato que quieras pasar a la vista
        ];
        
        $pdf = Pdf::setPaper('legal', 'landscape')
        ->loadView('pdf.caja.resumen-ingresos-egresos',
            compact('ingresos', 'egresos', 'resumen', 'institucion', 
                    'usuario', 'fechas', 'data'));
        return $pdf->stream('libro_diario.pdf');
    }

    private function getIngresos($request)
    {
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;

        return ItComprobantePago::whereDate('cp_fecha_cobro', '>=', $fechaInicial)
            ->whereDate('cp_fecha_cobro', '<=', $fechaFinal)
            ->where(function ($query) {
                $query->where('cp_tipo', 1)
                    ->orWhere('cp_tipo', 2);
            })
            ->orderBy('cp_fecha_cobro', 'asc')
            ->get();
    }

    private function getEgresos($request)
    {
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;

        return ItComprobantePago::whereDate('cp_fecha_cobro', '>=', $fechaInicial)
            ->whereDate('cp_fecha_cobro', '<=', $fechaFinal)
            ->where('cp_tipo', 3)
            ->orderBy('cp_fecha_cobro', 'asc')
            ->get();
    }

    private function getResumen($request, $ingresos, $egresos){

        $usCodigo = '';
        if(auth()->user() === null){
            $token = PersonalAccessToken::where('tokenable_id', $request->usuario)->first();

            if (!$token) {
                return Response::HTTP_UNAUTHORIZED;
            }
            $usuario = User::find($token->tokenable_id);
            $nombreUsuario = $usuario->trabajador->tr_nombre . ' ' . $usuario->trabajador->tr_apellido;
        }
        else{
            $nombreUsuario = auth()->user()->trabajador->tr_nombre . ' ' . auth()->user()->trabajador->tr_apellido;

        }
        
        return [
            'usuario' => $nombreUsuario,
            'ingreso' => $ingresos->sum('cp_pago'),
            'egreso' => $egresos->sum('cp_pago'),
            'total' => $ingresos->sum('cp_pago') - $egresos->sum('cp_pago')
        ];
    }
}

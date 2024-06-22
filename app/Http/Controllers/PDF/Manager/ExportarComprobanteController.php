<?php

namespace App\Http\Controllers\PDF\Manager;

use App\Http\Controllers\Controller;
use App\Models\ItComprobantePago;
use App\Models\ItInstitucion;
use App\Models\ItMatricula;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;
use Src\manager\caja\infrastructure\resources\ListGetAllIngresosGETResources;
use Src\manager\certificado_antecedentes\infrastructure\resources\ListPagoCuotaResource;
use Src\manager\matricula\infrastructure\resources\ListAllMatriculaResource;
use Symfony\Component\HttpFoundation\Response;

class ExportarComprobanteController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $ingresos = $this->getIngresos($request, auth()->user());

            return response()->json([
                'message' => 'Lista de comprobantes',
                'status' => true,
                'data' => ListGetAllIngresosGETResources::collection($ingresos),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'message' => 'Error al exportar comprobante',
                'status' => false,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function generarPdf(Request $request)
    {
        if (auth()->user() === null) {
            $token = PersonalAccessToken::where('tokenable_id', $request->usuario)->first();

            if (!$token) {
                return Response::HTTP_UNAUTHORIZED;
            }
            $usuario = User::find($token->tokenable_id);
        } else {
            $usuario = auth()->user();
        }

        $fechas = [
            'desde' => $request->fechaInicial,
            'hasta' => $request->fechaFinal,
        ];
        $institucion = ItInstitucion::first();
        $ingresos = $this->getIngresos($request, $usuario);
        $ingreso = ListGetAllIngresosGETResources::collection($ingresos);
        $ingresos = $ingreso->toArray($request);

        $data = [
            'title' => 'Mi primer PDF generado con Laravel y DOMPDF',
            'date' => date('m/d/Y'),
            // cualquier otro dato que quieras pasar a la vista
        ];

        $pdf = Pdf::loadView('pdf.exportar-comprobante',
            compact('ingresos', 'institucion',
                'usuario', 'fechas', 'data'));

        // download PDF
        return $pdf->stream('comprobante.pdf');
    }

    private function getIngresos($request, User $user)
    {
        $fechaInicial = $request->fechaInicial;
        $fechaFinal = $request->fechaFinal;

        return ItComprobantePago::whereDate('cp_fecha_cobro', '>=', $fechaInicial)
            ->whereDate('cp_fecha_cobro', '<=', $fechaFinal)
            ->where(function ($query) {
                $query->where('cp_tipo', 1)
                    ->orWhere('cp_tipo', 2);
            })
            ->where('us_codigo', $user->us_codigo)
            ->orderBy('cp_fecha_cobro', 'asc')
            ->get();
    }

    public function generarComprobantePdf(ItComprobantePago $comprobante, User $user, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();

        if (!$token) {
            return Response::HTTP_UNAUTHORIZED;
        }
        $usuario = User::find($token->tokenable_id);

        $institucion = ItInstitucion::first();

        if ($comprobante->cp_tipo == 2) {
            $ma_codigo = ItMatricula::join('it_sede as sede', 'it_matricula.se_codigo', '=', 'sede.se_codigo')
                ->join('it_estudiante as estudiante', 'it_matricula.es_codigo', '=', 'estudiante.es_codigo')
                ->join('it_programacion as programacion', 'programacion.ma_codigo', '=', 'it_matricula.ma_codigo')
                ->join('it_cuota as cuota', 'cuota.pg_codigo', '=', 'programacion.pg_codigo')
                ->join('it_pago_cuota as pago', 'pago.ct_codigo', '=', 'cuota.ct_codigo')
                ->join('it_comprobante_pago as comprobante', 'comprobante.pc_codigo', '=', 'pago.pc_codigo')
                ->where('comprobante.cp_codigo', $comprobante->cp_codigo)
                ->first('it_matricula.ma_codigo');
            
            if ($ma_codigo) {
                $matricula = ItMatricula::find($ma_codigo['ma_codigo']);
                $matriculaResourse = new ListAllMatriculaResource($matricula);

                $matriculas = $matriculaResourse->toArray($request);
                $informacion = json_decode($comprobante->cp_informacion);

                $pdf = Pdf::setPaper('A4', 'portrait')
                    ->loadView('pdf.comprobante',
                        compact('usuario', 'matriculas', 'informacion', 'institucion', 'comprobante')
                    );
                return $pdf->stream('comprobante' . $comprobante->cp_codigo . '.pdf');
            } else {
                $programacion = $comprobante->pagoCuota->cuota->programacion;
                $programacionResource = new ListPagoCuotaResource($programacion);
                $programacion = $programacionResource->toArray($request);

                $informacion = json_decode($comprobante->cp_informacion);

                $pdf = Pdf::setPaper('A4', 'portrait')
                    ->loadView('pdf.comprobante',
                        compact('usuario', 'programacion', 'informacion', 'institucion', 'comprobante')
                    );
                return $pdf->stream('comprobante' . $comprobante->cp_codigo . '.pdf');
            }

        }
        if ($comprobante->cp_tipo == 1) {
            $informacion = json_decode($comprobante->cp_informacion);

            $pdf = Pdf::setPaper('A4', 'portrait')
                ->loadView('pdf.comprobante-producto',
                    compact('usuario', 'informacion', 'institucion', 'comprobante')
                );
            return $pdf->stream('comprobante' . $comprobante->cp_codigo . '.pdf');

        }
    }

    public function generarComprobanteTicketPdf(ItComprobantePago $comprobante, User $user, Request $request, float $height)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();

        if (!$token) {
            return Response::HTTP_UNAUTHORIZED;
        }
        $usuario = User::find($token->tokenable_id);

        $institucion = ItInstitucion::first();

        if ($comprobante->cp_tipo == 1) {
            $informacion = json_decode($comprobante->cp_informacion);

            $height = $height * 3.3;

            $pdf = Pdf::setPaper([0, 0, 226.772, $height], 'portrait')
                ->loadView('pdf.comprobante-producto-ticket',
                    compact('usuario', 'informacion', 'institucion', 'comprobante')
                );
            return $pdf->stream('comprobante' . $comprobante->cp_codigo . '.pdf');

        }
    }

    public function render(ItComprobantePago $comprobante, User $user, Request $request)
    {
        $token = PersonalAccessToken::where('tokenable_id', $user->us_codigo)->first();

        if (!$token) {
            return Response::HTTP_UNAUTHORIZED;
        }
        $usuario = User::find($token->tokenable_id);

        $institucion = ItInstitucion::first();

        if ($comprobante->cp_tipo == 2) {
            $ma_codigo = ItMatricula::join('it_sede as sede', 'it_matricula.se_codigo', '=', 'sede.se_codigo')
                ->join('it_estudiante as estudiante', 'it_matricula.es_codigo', '=', 'estudiante.es_codigo')
                ->join('it_programacion as programacion', 'programacion.ma_codigo', '=', 'it_matricula.ma_codigo')
                ->join('it_cuota as cuota', 'cuota.pg_codigo', '=', 'programacion.pg_codigo')
                ->join('it_pago_cuota as pago', 'pago.ct_codigo', '=', 'cuota.ct_codigo')
                ->join('it_comprobante_pago as comprobante', 'comprobante.pc_codigo', '=', 'pago.pc_codigo')
                ->where('comprobante.cp_codigo', $comprobante->cp_codigo)
                ->first('it_matricula.ma_codigo');

            if ($ma_codigo) {
                $matricula = ItMatricula::find($ma_codigo['ma_codigo']);
                //dd($matricula);
                $matriculaResourse = new ListAllMatriculaResource($matricula);

                $matriculas = $matriculaResourse->toArray($request);
                $informacion = json_decode($comprobante->cp_informacion);

                $pdf = Pdf::setPaper([0, 0, 226.772, 750], 'portrait')
                    ->loadView('pdf.comprobante-ticket',
                        compact('usuario', 'matriculas', 'informacion', 'institucion', 'comprobante')
                    );
                return $pdf->stream('comprobante' . $comprobante->cp_codigo . '.pdf');
            } else {
                $programacion = $comprobante->pagoCuota->cuota->programacion;
                $programacionResource = new ListPagoCuotaResource($programacion);
                $programacion = $programacionResource->toArray($request);

                $informacion = json_decode($comprobante->cp_informacion);

                $pdf = Pdf::setPaper([0, 0, 226.772, 750], 'portrait')
                    ->loadView('pdf.comprobante-ticket',
                        compact('usuario', 'programacion', 'informacion', 'institucion', 'comprobante')
                    );
                return $pdf->stream('comprobante' . $comprobante->cp_codigo . '.pdf');
            }

        }
        if ($comprobante->cp_tipo == 1) {
            $informacion = json_decode($comprobante->cp_informacion);

            //$pdf = Pdf::setPaper('A4', 'portrait')

            return view('pdf.comprobante-producto-ticket',
                compact('usuario', 'informacion', 'institucion', 'comprobante')
            );

        }

    }

    public function setHeight(Request $request)
    {
        $height = $request->input('height');
        //Session::put('pdf_height', $height);
        //dd($height);
        return response()->json([
            'status' => true,
            'height' => $height,
        ]);
    }
}

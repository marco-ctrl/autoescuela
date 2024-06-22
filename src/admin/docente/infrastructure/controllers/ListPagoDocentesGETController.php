<?php

namespace Src\admin\docente\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Src\admin\docente\infrastructure\resources\PagoDocenteResource;
use Symfony\Component\HttpFoundation\Response;

final class ListPagoDocentesGETController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $term = $request->input('term');

            $docente = ItDocente::query()
            ->where(function ($query) use ($term) {
                $query->where('do_nombre', 'LIKE', '%' . $term . '%')
                    ->orWhere('do_apellido', 'LIKE', '%' . $term . '%')
                    ->orWhere('do_documento', 'LIKE', '%' . $term . '%')
                    ->orWhere(DB::raw("CONCAT(do_nombre, ' ', do_apellido)"), 'LIKE', '%' . $term . '%');
            })
            ->orderBy('do_codigo', 'Desc')
            ->paginate(10);
            
            $docenteData = PagoDocenteResource::collection($docente);

            $paginationData = $docente->toArray();
            $pagination = [
                'current_page' => $paginationData['current_page'],
                'total' => $paginationData['total'],
                'per_page' => $paginationData['per_page'],
                'last_page' => $paginationData['last_page'],
                'next_page_url' => $paginationData['next_page_url'],
                'prev_page_url' => $paginationData['prev_page_url'],
                'from' => $paginationData['from'],
                'to' => $paginationData['to'],
                'links' => $paginationData['links'],
            ];

            return response()->json([
                'status' => true,
                'data' => $docenteData,
                'pagination' => $pagination,
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => __('failed to list pago docente'),
                'error' => $e->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

<?php

namespace Src\admin\matricula\infrastructure\controllers;

use App\Http\Controllers\Controller;
//use App\Http\Resources\Admin\MatriculaResource;
use App\Models\ItMatricula;
use Illuminate\Http\JsonResponse;
use Src\admin\matricula\infrastructure\resources\ListAllMatriculaResource;
use Symfony\Component\HttpFoundation\Response;

final class ListAllMatriculaGetController extends Controller
{

    public function index(): JsonResponse
    {
        try {
            $matriculas = ItMatricula::with('usuario.trabajador')
            ->orderBy('ma_codigo', 'desc')
            ->paginate(8);
            
            $matriculasResource = ListAllMatriculaResource::collection($matriculas);

            $paginationData = $matriculas->toArray();

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
                'data' => $matriculasResource,
                'pagination' => $pagination,
            ], Response::HTTP_OK);
            //return $matriculasResource->response()->setStatusCode(200);
        } catch (\Exception $ex) {
            return response()->json([
                'status' => false,
                'message' => __('Failed to list matriculas'),
                'error' => $ex->getMessage(),
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}

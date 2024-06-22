<?php

namespace Src\manager\docente\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItDocente;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\manager\docente\infrastructure\resources\AutocompleteDocenteResource;
use Symfony\Component\HttpFoundation\Response;

final class AutocompleteDocenteGETController extends Controller { 

 public function index(Request $request): JsonResponse { 
    try {
        $term = $request->input('term');

        $docentes = ItDocente::where('do_nombre', 'LIKE', '%' . $term . '%')
            ->orWhere('do_apellido', 'LIKE', '%' . $term . '%')
            ->orWhere('do_documento', 'LIKE', '%' . $term . '%')
            ->latest('do_codigo')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => true,
            'data' => AutocompleteDocenteResource::collection($docentes),
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list horarios'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
}
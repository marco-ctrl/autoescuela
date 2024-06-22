<?php

namespace Src\admin\producto\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItProducto;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Src\admin\producto\infrastructure\resources\AutoCompleteProductoIngresoResource;
use Symfony\Component\HttpFoundation\Response;

final class AutoCompleteProductoEgresoGETController extends Controller { 

 public function index(Request $request):JsonResponse { 
    try {
        $term = $request->input('term');

        $producto = ItProducto::where('pr_descripcion', 'LIKE', '%' . $term . '%')
            ->where('pr_tipo_producto', 1)
            ->latest('pr_codigo')
            ->limit(5)
            ->get();

        return response()->json([
            'status' => true,
            'data' => AutoCompleteProductoIngresoResource::collection($producto),
        ], Response::HTTP_OK);
    } catch (\Exception $ex) {
        return response()->json([
            'status' => false,
            'message' => __('Failed to list producto'),
            'error' => $ex->getMessage(),
        ], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
 }
}
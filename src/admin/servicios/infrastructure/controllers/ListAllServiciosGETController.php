<?php
namespace Src\admin\servicios\infrastructure\controllers;

use App\Http\Controllers\Controller;
use App\Models\ItServicio;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class ListAllServiciosGETController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try{
            $servicios = ItServicio::where('sv_descripcion', 'like', '%'.$request->input('term').'%')->get();
            
            return response()->json([
                'message' => __('lista de servicios'),
                'data' => $servicios,
                'status' => true,
            ], Response::HTTP_OK);
        }
        catch(\Exception $e){
            return response()->json([
                'message' => __('error al listar los servicios'),
                'error' => $e->getMessage(),
                'status' => false,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
?>


<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Tienda;
use App\Http\Resources\TiendaResource;
use Illuminate\Http\Request;

class TiendaController extends Controller
{
    /**
     * Get a list of active Tiendas
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tiendas = Tienda::where('estado', 1)->get();

        $response = [
            'status' => 1,
            'code' => 200,
            'msg' => 'OK',
            'data' => TiendaResource::collection($tiendas),
            'data_error' => []
        ];

        return response()->json($response);
    }
}

<?php


namespace App\Http\Controllers\Api\V1;


use App\Http\Controllers\Controller;
use App\Http\Enums\TypeArchivoImage;

use App\Http\Resources\BannerResource;
use App\Http\Resources\CategoriaHomeResource;
use App\Http\Resources\CategoriaResource;
use App\Http\Resources\CuidadoPersonalResource;
use App\Models\Banners;
use App\Models\Categorias;
use App\Models\Cupones;
use App\Models\MensajesCuidadoPersonal;
use App\Traits\ApiResponser;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    use ApiResponser;

    public function index()
    {
        $banners = Banners::where('active', 1)->orderBy('position')->get();
        $categorias = Categorias::with(['productos' => function($q){
            $q->where('active', 1)->take(10)->with(['categoria', 'subcategoria']);
        }])->where('parent_id',0)->where('active', 1)->orderBy('position')->get();
        $cuidadoPersonal = MensajesCuidadoPersonal::where('active', 1)->orderBy('orden')->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'banners' => BannerResource::collection($banners),
                'categorias' => CategoriaHomeResource::collection($categorias),
                'cuidado_personal' => CuidadoPersonalResource::collection($cuidadoPersonal),
            ]
        ]);
    }

    public function getProductos()
    {
        // 1. Traer categorías con sus subcategorías
        $categorias = Categorias::with(['subCategories' => function ($q) {
            $q->where('active', 1)->orderBy('position');
        }])
            ->where('parent_id', 0)
            ->where('active', 1)
            ->orderBy('position')
            ->get();

        // 2. Traer productos agrupados por categoría
        $productosPorCategoria = Categorias::with([
            'productos' => function ($q) {
                $q->where('active', 1)
                    ->with(['categoria', 'subcategoria']);
            }
        ])
            ->where('parent_id', 0)
            ->where('active', 1)
            ->orderBy('position')
            ->get();

        // 3. Retornar en un solo JSON
        return response()->json([
            'categorias' => CategoriaResource::collection($categorias),
            'categoriaProductos' => CategoriaHomeResource::collection($productosPorCategoria),
        ]);
    }



    public function contactanos(Request $request)
    {
        DB::beginTransaction();
        try {
            $contacto=Contactos::create(
                [
                    'nombre_completo' => $request->nombre_apellidos,
                    'email' => $request->email,
                    'asunto' => $request->asunto,
                    'mensaje' => $request->mensaje
                ]
            );
            Mail::to($contacto->email)->cc(['dechiripaperu@gmail.com','c.augusto.espinoza@gmail.com'])->send(new ContactoMail($contacto));

            DB::commit();
        } catch (Exception $exc) {
            DB::rollBack();
            $status = 0;
            $code = 500;
            $data = $exc->getMessage();
            return $this->apiResponse($status, $code, $data);
        }

        $row = new \stdClass();
        $row->msg = 'Registro guardado correctamente';

        $status = 1;
        $code = 201;
        $data = $row;

        return $this->apiResponse($status, $code, $data);
    }

    public function validarCupon(Request $request){
        $cupon = Cupones::where('codigo',$request->codigo)->where('estado',1)->first();

        if($cupon){

            $status = 1;
            $code   = 201;
            $row                = new \stdClass();
            $row->code           = $cupon->codigo;
            $row->monto           = $cupon->monto;
            $data   = $row;
            return $this->apiResponse($status,$code,$data);

        }
        $row                = new \stdClass();
        $row->msg           = 'El cupón no esta activo';

        $status = 0;
        $code   = 200;
        $data   = $row;
        return $this->apiResponse($status,$code,$data);

    }

}

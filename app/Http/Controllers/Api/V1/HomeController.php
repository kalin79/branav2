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
use App\Models\Contacto;
use App\Models\Reclamacion;
use App\Models\Cupones;
use App\Models\MensajesCuidadoPersonal;
use App\Mail\ContactoMail;
use App\Mail\ReclamacionMail;
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
        $categorias = Categorias::with([
            'productos' => function ($q) {
                $q->where('active', 1)->take(10)->with(['categoria', 'subcategoria']);
            }
        ])->where('parent_id', 0)->where('active', 1)->orderBy('position')->get();
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
        $categorias = Categorias::with([
            'subCategories' => function ($q) {
                $q->where('active', 1)->orderBy('position');
            }
        ])
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



    public function reclamacionStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nombres' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'tipo_documento' => 'required|string|max:50',
            'nro_documento' => 'required|string|max:20',
            'nro_celular' => 'required|string|max:20',
            'correo_electronico' => 'required|email|max:255',
            'tipo' => 'required|in:reclamo,queja',
            'detalle' => 'required|string',
            'pedido' => 'required|string',
            'tyc' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(0, 422, $validator->errors());
        }

        DB::beginTransaction();
        try {
            $reclamacion = Reclamacion::create($request->all());

            // Enviar correo
            Mail::to('dechiripaperu@gmail.com')->cc(['c.augusto.espinoza@gmail.com', $reclamacion->correo_electronico])->send(new ReclamacionMail($reclamacion));

            DB::commit();
        } catch (Exception $exc) {
            DB::rollBack();
            return $this->apiResponse(0, 500, $exc->getMessage());
        }

        return $this->apiResponse(1, 201, ['msg' => 'Reclamación registrada con éxito', 'id' => $reclamacion->id]);
    }

    public function contactanos(Request $request)
    {
        // Validar los campos si es necesario
        $validator = Validator::make($request->all(), [
            'nombre_apellidos' => 'required|string|max:255',
            'correo' => 'required|email|max:255',
            'nro_celular' => 'required|string|max:20',
            'asunto' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'tyc' => 'required|boolean',
        ]);

        if ($validator->fails()) {
            return $this->apiResponse(0, 422, $validator->errors());
        }

        DB::beginTransaction();
        try {
            $contacto = Contacto::create(
                [
                    'nombre_apellidos' => $request->nombre_apellidos,
                    'correo' => $request->correo,
                    'nro_celular' => $request->nro_celular,
                    'asunto' => $request->asunto,
                    'mensaje' => $request->mensaje,
                    'tyc' => $request->tyc
                ]
            );

            // Enviar correo a los destinatarios especificados
            Mail::to('dechiripaperu@gmail.com')->cc(['c.augusto.espinoza@gmail.com'])->send(new ContactoMail($contacto));

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

    public function validarCupon(Request $request)
    {
        $cupon = Cupones::where('codigo', $request->codigo)->where('estado', 1)->first();

        if ($cupon) {

            $status = 1;
            $code = 201;
            $row = new \stdClass();
            $row->code = $cupon->codigo;
            $row->monto = $cupon->monto;
            $data = $row;
            return $this->apiResponse($status, $code, $data);

        }
        $row = new \stdClass();
        $row->msg = 'El cupón no esta activo';

        $status = 0;
        $code = 200;
        $data = $row;
        return $this->apiResponse($status, $code, $data);

    }

}

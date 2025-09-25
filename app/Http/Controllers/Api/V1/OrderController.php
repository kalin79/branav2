<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Models\Clientes;

use App\Models\District;
use App\Models\Province;
use App\Models\Department;

use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\OrderShippingInformation;
use App\Http\Enums\TypePaymentVoucher;
use App\Http\Enums\StatusSale;
use App\Http\Enums\StatusSalePay;
use App\Traits\ApiResponser;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;
use MercadoPago;
use MercadoPago\SDK;
use App\Services\MercadoPagoService;
use MercadoPago\Client\Payment\PaymentClient;
//use App\Traits\Notification;
use Illuminate\Support\Facades\Mail;
class OrderController extends Controller
{
    use ApiResponser;
    //use Notification;

    public $mercadoPagoService;

    public function __construct(MercadoPagoService $mercadoPagoService)
    {
        $this->mercadoPagoService = $mercadoPagoService;
    }

    public function storeDatosCliente(Request $request){
        DB::beginTransaction();
        try {
            $dataCliente = [
                'nombres'=>$request->nombres,
                'apellidos'=>$request->apellidos,
                'nro_documento'=>$request->documento,
                'celular'=>$request->celular,
                'email'=>$request->email,
                'direccion'=>$request->direccion,
                'departamento_id'=>$request->departamento,
                'provincia_id'=>$request->provincia,
                'distrito_id'=>$request->distrito,
            ];
            if($request->cliente_id){
                $cliente = Clientes::find($request->cliente_id);
                if($cliente){
                    $cliente->update($dataCliente);
                }else{
                    $dataCliente['password']=bcrypt($request->documento);
                    $cliente = Clientes::create($dataCliente);
                }
            }else
            {
                $dataCliente['password']=bcrypt($request->documento);
                $cliente = Clientes::create($dataCliente);
            }

            $sale = Sale::create([
                'client_id'=>$cliente->id,
                'tipo_voucher_id'=>$request->tipoRecibo==1?TypePaymentVoucher::BOLETA:TypePaymentVoucher::FACTURA,
                'ruc'=>$request->ruc,
                'razon_social'=>$request->razonSocial,
                'direccion'=>$request->direccionRUC,
                'tyc'=>$request->tyc,
                'politica_privacidad'=>$request->politica,
                'enviar_correo_ofertas'=>$request->ofertas,
            ]);
            $sale->update([
                'order_number'                  => '00'.$sale->id .' - '.$this->generateRandomStr(),
                'status_pay'                    => StatusSalePay::PENDIENTE_PAGO,
                'status_id'                     => StatusSale::PENDING
            ]);
            //$cupon_descuento = Cupones::where('codigo',$request->codigoDescuento)->update(['estado'=>0]);
            $obj_productos = $request->productos;
            // dd($obj_productos);
            if (count($obj_productos) > 0) {
                $total = 0;
                foreach ($obj_productos as $sale_product) {
                    $subtotal = $sale_product['quantity'] * $sale_product['precio_actual'];
                    $product = $sale->saleProducts()->create([
                        'product_id' => $sale_product['id'],
                        'product_name'=> $sale_product['titulo'],
                        'product_description'=> $sale_product['presentacion'],
                        'product_image'=> $sale_product['poster'],
                        'detail'=> $sale_product['subcategoria'],
                        'unit_price' => $sale_product['precio_actual'],
                        'total_price' => $sale_product['precio_actual'] ? number_format($sale_product['precio_actual'] * $sale_product['quantity'], 2, '.', '') : '',
                        'quantity' => $sale_product['quantity'],
                    ]);

                    $total += $subtotal;
                }
                $sale->update(['total_price' => $total]);
            }

            //$this->sendMailSale($sale);


           // $preference = $this->mercadoPagoService->createPreference($items, $sale->id);
            DB::commit();

            //$this->sendMailSale($sale);
        } catch (\Exception $exc) {
            DB::rollBack();
            $status = 0;
            $code = 500;
            $data = $exc->getMessage();
            return $this->apiResponse($status, $code, $data);
        }

        $data = new \stdClass();
        $data->order_id = $sale->id;
        $data->order_no = $sale->order_number;
        $status = 1;
        $code = 201;

        return $this->apiResponse($status, $code, $data);
    }

    public function checkout(Request $request, $sale)
    {
        $sale = Sale::find($sale);
        //dd($sale);
        $sale->update([
            'tienda_id'=>$request->idTienda,
            'discount'=>$request->montoDescuento,
            'total'=>$request->totalPagar,
            'type'=>$request->tipoRecojo==1?'DELIVERY':'RECOJO',
            'cost_delivery_district'=>$request->costoDelivery,
            'codigo_descuento'=>$request->codigoDescuento
        ]);
        $items = $sale->saleProducts->map(function($p) {
            return [
                'title' => "Producto #{$p->product_id}",
                'quantity' => $p->quantity,
                'currency_id' => 'PEN',
                'unit_price' => (float) $p->unit_price,
            ];
        })->toArray();
        //dd($items);
        $preference = $this->mercadoPagoService->createPreference($items, $sale->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Preferencia de pago creada',
            'data' => [
                'preference_id' => $preference->id,
                'init_point' => $preference->init_point,
            ]
        ]);
    }

    public function handle(Request $request)
    {
        \Log::info('Webhook recibido', $request->all());

        if ($request->type === 'payment') {
            $client = new PaymentClient();
            $payment = $client->get($request->data['id']);

            $saleId = $payment->external_reference;
            $sale = Sale::find($saleId);

            if ($sale) {
                $sale->payments()->create([
                    'payment_id' => $payment->id,
                    'status' => $payment->status,
                    'payment_type' => $payment->payment_type_id,
                    'transaction_amount' => $payment->transaction_amount,
                    'payload' => $payment,
                ]);

                $sale->update(['status' => $payment->status === 'approved' ? 'paid' : $payment->status]);
            }
        }

        return response()->json(['status' => 'ok']);
    }


    public function show($sale)
    {
        $sale = Sale::find($sale);
        $data = new \stdClass();
        //$data->category                     = $this->category($product);
        $data->sale = $this->sale($sale);

        $status = 1;
        $code = 200;
        return $this->apiResponse($status, $code, $data);
    }
    public function showByOrderNumber(Request $request)
    {
        Log::info("numero_order", $request->all());
        $sale = Sale::where('order_number', $request->numero_orden)->first();
        $data = new \stdClass();
        //$data->category                     = $this->category($product);
        $data->sale = $this->sale($sale);

        $status = 1;
        $code = 200;
        return $this->apiResponse($status, $code, $data);
    }

    public function sale(Sale $sale)
    {
        $row_sale = new \stdClass();
        $row_sale->nombre = $sale->nombre;
        $row_sale->apellidos = $sale->apellidos ? true : false;
        $row_sale->tipo_documento = $sale->tipo_documento;
        $row_sale->numero_documento = $sale->numero_documento;
        $row_sale->email = $sale->email;
        $row_sale->telefono = $sale->telefono;


        $response = [];
        foreach ($sale->saleProducts as $product) {
            $row_product = new \stdClass();
            $row_product->cantidad = $product->quantity;
            $row_product->sorteo_id = $product->sorteo_id;
            $row_product->precio = $product->unit_price;
            $response[] = $row_product;
        }
        $row_sale->productoObjListado = $response;

        /*$row_voucher = new \stdClass();
        $row_voucher->value = $sale->tipo_voucher_id;
        $row_voucher->text = Type::find($sale->tipo_voucher_id)->name;
        $row_sale->comprobanteObjTipo = $row_voucher;*/

        return $row_sale;
    }

    public function sendMailSale($sale)
    {

        /*$correos = [
            $sale->contact_email,
            'pedidos@floreriasumaq.pe'
        ];
        foreach($correos as $correo){
            Mail::to($correo)->send( new OrderSend($sale));
        }
*/

    }

    function generateRandomStr($length = 8)
    {
        $symbols = "0123456789";
        $characters = $symbols;
        $charactersLength = strlen($characters);
        $randomStr = null;
        for ($i = 0; $i < $length; $i++) {
            $randomStr .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomStr;
    }

}

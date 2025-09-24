<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Models\Participante;
use App\Models\Product;
use App\Models\District;
use App\Models\Province;
use App\Models\Department;
use App\Models\PaymentMethod;
use App\Models\Dedication;
use App\Models\Type;
use App\Models\Sale;
use App\Models\SaleProduct;
use App\Models\OrderShippingInformation;
use App\Http\Enums\TypePaymentVoucher;
use App\Http\Enums\StatusSale;
use App\Http\Enums\StatusSalePay;
use App\Http\Requests\OrderStoreRequest;
use App\Mail\OrderSend;
use App\Models\Cupones;
use App\Traits\ApiResponser;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;
/*use MercadoPago;
use MercadoPago\SDK;
use App\Services\MercadoPagoService;*/
//use App\Traits\Notification;
use Illuminate\Support\Facades\Mail;
class OrderController extends Controller
{
    use ApiResponser;
    //use Notification;

    /*public $mercadoPagoService;

    public function __construct(MercadoPagoService $mercadoPagoService)
    {
        $this->mercadoPagoService = $mercadoPagoService;
    }*/

    public function store(Request $request)
    {
        // dd(json_encode($request->transaction_result));
        DB::beginTransaction();
        try {

            $sale = Sale::create([
                'purchase_number' => $request->purchaseNumber,
                'participante_id' => $request->participante_id,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'sub_total' => $request->montoSubTotal,
                'total_price' => $request->montoTotal,
                'status_pay' => $request->status_pay,
                'discount' => $request->montoDescuento,
                'paid_at' => date("Y-m-d"),
                'transaction_id' => $request->transaction_id,
                'transaction_result' => json_encode($request->transaction_result)
            ]);
            //$cupon_descuento = Cupones::where('codigo',$request->codigoDescuento)->update(['estado'=>0]);
            $obj_productos = $request->sorteoListado;
            // dd($obj_productos);
            if (count($obj_productos) > 0) {
                foreach ($obj_productos as $sale_product) {
                    $product = $sale->saleProducts()->create([
                        'product_id' => $sale_product['id'],
                        'sorteo_id' => $sale_product['id'],
                        'unit_price' => $sale_product['price'],
                        'total_price' => $sale_product['price'] ? number_format($sale_product['price'] * $sale_product['quantity'], 2, '.', '') : '',
                        'quantity' => $sale_product['quantity'],
                    ]);
                }
            }
            $participante = Participante::where('id', $request->participante_id)->first();

            if ($participante) {
                if ($request->montoDescuento != '' && $request->montoDescuento > 0) {
                    $participante->update(['tickets_gratis' => 0]);
                }
            }

            $sale->generarComprobanteSunat($request);
            $this->sendMailSale($sale);
            DB::commit();

            //$this->sendMailSale($sale);
        } catch (Exception $exc) {
            DB::rollBack();
            $status = 0;
            $code = 500;
            $data = $exc;
            return $this->apiResponse($status, $code, $data);
        }

        $data = new \stdClass();
        $data->order_id = $sale->id;
        $data->order_no = $sale->purchase_number;

        $status = 1;
        $code = 201;

        return $this->apiResponse($status, $code, $data);

    }

    public function visitanteOrderStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $participante = Participante::where('email', $request->email)->where('dni', $request->numero_documento)->first();

            if (!$participante) {
                $participante = Participante::create([
                    'email' => $request->email,
                    'dni' => $request->numero_documento,
                    'nombres' => $request->nombres,
                    'apellido_paterno' => $request->apellidos,
                    'dni' => $request->numero_documento,
                    'celular' => $request->telefono,
                    'email' => $request->email,
                ]);
            }

            $sale = Sale::create([
                'purchase_number' => $request->purchaseNumber,
                'participante_id' => $participante->id,
                'nombres' => $request->nombres,
                'apellidos' => $request->apellidos,
                'tipo_documento' => $request->tipo_documento,
                'numero_documento' => $request->numero_documento,
                'email' => $request->email,
                'telefono' => $request->telefono,
                'sub_total' => $request->montoSubTotal,
                'total_price' => $request->montoTotal,
                'status_pay' => $request->status_pay,
                'discount' => $request->montoDescuento,
                'paid_at' => date("Y-m-d"),
                'transaction_id' => $request->transaction_id,
                'transaction_result' => json_encode($request->transaction_result)
            ]);
            //$cupon_descuento = Cupones::where('codigo',$request->codigoDescuento)->update(['estado'=>0]);
            $obj_productos = $request->sorteoListado;
            if (count($obj_productos) > 0) {
                foreach ($obj_productos as $sale_product) {
                    $product = $sale->saleProducts()->create([
                        'product_id' => $sale_product['id'],
                        'sorteo_id' => $sale_product['id'],
                        'unit_price' => $sale_product['price'],
                        'total_price' => $sale_product['price'] ? number_format($sale_product['price'] * $sale_product['quantity'], 2, '.', '') : '',
                        'quantity' => $sale_product['quantity'],
                    ]);
                }
            }

            $sale->generarComprobanteSunat($request);
            $this->sendMailSale($sale);
            DB::commit();
        } catch (Exception $exc) {
            DB::rollBack();
            $status = 0;
            $code = 500;
            $data = $exc;
            return $this->apiResponse($status, $code, $data);
        }

        $data = new \stdClass();
        $data->order_id = $sale->id;
        $data->order_no = $sale->order_number;

        $status = 1;
        $code = 201;

        return $this->apiResponse($status, $code, $data);

    }

    /*public function storeProcessPayment(Request $request,$sale)
    {
        Log::info('parametros=>',$request->all());
        $sale = Sale::find($sale);
        SDK::setAccessToken($this->mercadoPagoService->token_mp);
        //guardamos los datos de la transacción
        $payment                        = new MercadoPago\Payment();
        $payment->transaction_amount    = (float)$request->transactionAmount;//*
        $payment->token                 = $request->token; //*
        $payment->description           = $request->description; //*
        $payment->installments          = (int)$request->installments; //*
        $payment->payment_method_id     = $request->paymentMethodId; //*
        $payment->issuer_id             = (int) $request->issuer;

        //guardamos los datos del que paga
        $payer = new MercadoPago\Payer();
        $payer->email = $request->email; //*
        $payer->identification = array(
            "type"      => $request->docType, //"DNI"
            "number"    =>$request->docNumber //"12345678"
        );
        $payment->payer = $payer;

        $payment->save();
        Log::info("payment",(array)$payment);
        $response = array(
            'status'        => $payment->status,
            'status_detail' => $payment->status_detail,
            'id'            => $payment->id
        );

        $estado_pago = StatusSalePay::PENDIENTE_PAGO;
        if($payment->status=="approved"){
            $estado_pago = StatusSalePay::PAGADO;
        }elseif($payment->status=="rejected"){
            $estado_pago = StatusSalePay::RECHAZADO;
        }

        $sale->update([
            'transaction_status'    => $payment->status,
            'transaction_result'    => $payment->status_detail,
            'transaction_id'        => $payment->id,
            'status_pay'            => $estado_pago,
            'paid_at'               => date('Y-m-d H:i:s')
        ]);

        $data                               = new \stdClass();
        $data->order_id                     = $response;
        $status = 1;
        $code   = 201;

        return $this->apiResponse($status,$code,$data);
    }*/

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

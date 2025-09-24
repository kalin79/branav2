<?php

namespace App\Models;

use App\Http\Enums\StatusSale;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Http\Filters\QueryFilter;

use App\Models\Client;
use App\Models\SaleProduct;
use App\Models\Status;
use App\Models\OrderShippingInformation;
use App\Models\PaymentMethod;
use App\Models\Type;

class Sale extends Model
{
    use HasFactory;
    use SoftDeletes;
    use QueryFilter;

    protected $table = 'sales';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'client_id',
        'client_address_id',
        'payment_method_id',
        'type',
        'paid_at',
        'date_send',
        'hour_range',
        'order_number',
        'quantity_products',
        'sub_total',
        'discount',
        'cost_delivery_district',
        'total_price',
        'how_much_pay',
        'voucher',
        'tipo_voucher_id',
        'ruc',
        'razon_social',
        'email',
        'phone',
        'direccion',
        'contact_cell_phone',
        'contact_email',
        'contact_name',
        'status_id',
        'transaction_id',
        'transaction_result',
        'transaction_status',
        'status_pay',
        'codigo_descuento',
        'comments',
        'discount_info',
        'tyc',
        'politica_privacidad',
        'enviar_correo_ofertas',
        'tienda_id',
        'order_shipping_information_id',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'date_send' => 'date',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [

    ];

    public static function storeValidation($request)
    {
        return [

            'typeUser'                  => 'required|numeric|min:1|max:2',
            'boolTerminos'              => 'required',
            'paymentType'               => 'required|numeric|min:1|max:2',

            'client_id'                 => 'nullable',
            'client_address_id'         => 'nullable',

            // Datos de Productos
            'productoObjListado'        => 'array|required',// [ { cantidad: 1, description: 'sss', id: 1, name: 'My Classic Love', photo: 'https://admin.floreriasumaq.pe/images/products/1/1-1621218681-60a1d5799edc2-pc.jpg', precio: 145.47} ]
            'productoTipoMoneda'        => 'required|numeric|min:1|max:1',
            'productoSimboloMoneda'     => 'required|string',
            'getExchangeRate'           => 'required',

            // Datos del Comprobante
            'comprobanteObjTipo.text'   => 'required',
            'comprobanteObjTipo.value'  => 'required|numeric',
            'comprobanteDireccion'      => 'nullable',
            'comprobanteEmail'          => 'nullable|email',
            'comprobanteRazonSocial'    => 'required', //vendrà el nombre o razon social
            'comprobanteRuc'            => 'required',//vendra el ruc o dni
            'comprobanteTelefono'       => 'nullable',

            // Datos del usuario logueo o visitante
            'contactoNombre'            => 'required',
            'contactoEmail'             => 'required',
            'contactoCelular'           => 'required|min:100000000|max:999999999|numeric',

            // Datos de la dedicatoria
            'dedicatoriaActivarFirma'   => 'required',
            'dedicatoriaFirma'          => 'required|string',
            'dedicatoriaActivarMensaje' => 'required',
            'dedicatoriaMensaje'        => 'required|string',

            // Datos de quien recibe o recepciona el pedido
            'recepcionaNombres'         => 'required|string',
            'recepcionaApellidos'       => 'required|string',
            'recepcionaCelular'         => 'required|min:100000000|max:999999999|numeric',
            'recepcionaDireccion'       => 'required|string',
            'recepcionaDni'             => 'nullable|min:10000000|max:99999999|numeric',
            'recepcionaPostalCodeMaps'  => 'nullable|numeric',
            'recepcionaProvinciaMaps'   => 'required|numeric',
            'recepcionaReferencia'      => 'nullable|string',
            'recepcionaObjDistrito'     => 'required',

            'recepcionaFecha'           => 'required',
            'recepcionaHora'            => 'required',

            'montoTotal'                => 'required',
            'cargoDelivery'             => 'required'

            //'cupon_expire_in' => 'numeric|required',
            //'active' => 'required',

        ];
    }

    public static function updateValidation($request)
    {
        return [

        ];
    }

    public static function attributesValidation()
    {
        return [

        ];
    }

    public function getFechaVentaAttribute(){
        return date("d/m/Y", strtotime($this->created_at));
    }

    public function getFechaEntregaAttribute(){
        return date("d/m/Y", strtotime($this->date_send));
    }

    public function getFechaPagoAttribute(){
        return $this->paid_at ? date("d/m/Y h:m", strtotime($this->paid_at)) : '';
    }



    public function client()
    {
        return $this->belongsTo(Clientes::class, 'client_id');
    }

    //
    public function orderShippingInformation()
    {
        return $this->belongsTo(OrderShippingInformation::class, 'order_shipping_information_id');
    }

    public function saleProducts()
    {
        return $this->hasMany(SaleProduct::class, 'sale_id');
    }



    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id');
    }

    public function statusPay()
    {
        return $this->belongsTo(Status::class, 'status_pay');
    }


    public function typeVoucher()
    {
        return $this->belongsTo(Type::class, 'tipo_voucher_id');
    }

    public function updateFileVoucher($file)
    {
        if ($file[0]) {
            $fileName = $this->id . "-" . time() . '-' . uniqid(). '.' . $file[0]->getClientOriginalExtension();
            Storage::disk('sales')->putFileAs($this->id, $file[0], $fileName);
            $this->name_file_pay = $fileName;
            $this->update();
        }
    }
}

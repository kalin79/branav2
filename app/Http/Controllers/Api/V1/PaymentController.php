<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\District;
use App\Models\Province;
use App\Models\Department;
use App\Models\PaymentMethod;
use App\Models\Dedication;
use App\Models\Type;
use App\Http\Enums\TypePaymentVoucher;

use App\Traits\ApiResponser;

use Illuminate\Http\Request;
use DB;

class PaymentController  extends Controller
{
    use ApiResponser;

    public function index()
    {
        $data                               = new \stdClass();
        $data->districs                     = $this->districts(null);
        $data->payment_methods              = $this->paymentMethod();
        $data->dedications                  = $this->dedications();
        $data->payment_vouchers             = $this->paymentVouchers();

        $status = 1;
        $code   = 200;
        $data   = $data;

        return $this->apiResponse($status,$code,$data);
    }

    public function districts($province_id = null)
    {
        if($province_id){
            $districts  = District::where('province_id',$province_id)->activos()->get();
        }else{
            $districts  = District::where('province_id',1501)->activos()->get(); //los distritos de lima
        }
        $response = [];
        foreach($districts AS $district){
            $row                    = new \stdClass();
            $row->id                = $district->id;
            $row->description       = ucwords(strtolower($district->description));
            $row->costo             =  $district->monto_delivery;
            $response[]             = $row;
        }

        return $response;
    }

    public function paymentMethod()
    {
        $payment_methods = PaymentMethod::activos()->get();
        $response = [];
        if(count($payment_methods) > 0){
            foreach($payment_methods AS $payment_method){
                $row                    = new \stdClass();
                $row->id                = $payment_method->id;
                $row->name              = $payment_method->name;
                $row->description       = $payment_method->description;
                $response[]             = $row;
            }
        }
        return $response;
    }

    public function dedications()
    {
        $dedications = Dedication::activos()->get();
        $response = [];
        if(count($dedications) > 0){
            foreach($dedications AS $dedication){
                $row                    = new \stdClass();
                $row->id                = $dedication->id;
                $row->title             = $dedication->title;
                $row->description       = $dedication->description;
                $response[]             = $row;
            }
        }
        return $response;
    }

    public function paymentVouchers()
    {
        $types      = Type::byMasterId(TypePaymentVoucher::master())->get();
        $response = [];
        if(count($types) > 0){
            foreach($types AS $type){
                $row                    = new \stdClass();
                $row->id                = $type->id;
                $row->name             = $type->name;
                $response[]             = $row;
            }
        }
        return $response;
    }


    public function schedule()
    {
        $response = [];
        $horarios = Schedule::finterAndPaginate();

        if ($horarios && count($horarios) > 0) {
            foreach ($horarios as $day) {
                $row_day = new \stdClass();
                $day_array = [];

                foreach($day as $index => $hour){
                    $row = new \stdClass();
                    $row->id            = $hour->id;
                    if($index == 0){
                        $row_day->day = $hour->dia;
                    }
                    $row->start_time    = $hour->start_time;
                    $row->end_time      = $hour->end_time;
                    $day_array[]         = $row;
                }
                $row_day->schedule = $day_array;
                $response[] = $row_day;
            }
        }
        return $response;
    }
}

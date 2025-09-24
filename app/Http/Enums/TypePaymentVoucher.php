<?php
namespace App\Http\Enums;

class TypePaymentVoucher extends Enum {

    const BOLETA        = 1;
    const FACTURA       = 2;

    protected static $masterId = 2;

    public static function master()
    {
        return self::$masterId;
    }
}

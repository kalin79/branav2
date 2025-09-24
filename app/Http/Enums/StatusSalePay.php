<?php
namespace App\Http\Enums;

class StatusSalePay extends Enum {

    const PENDIENTE_PAGO    = 5;
    const PAGADO            = 6;
    const RECHAZADO         = 7;

    protected static $masterId = 2;

    public static function master()
    {
        return self::$masterId;
    }
}

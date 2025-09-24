<?php
namespace App\Http\Enums;

class StatusSale extends Enum {

    const PENDING           = 1;
    const EN_CAMINO         = 2;
    const ENTREGADO         = 3;
    const RECHAZADO         = 4;

    protected static $masterId = 1;

    public static function master()
    {
        return self::$masterId;
    }
}

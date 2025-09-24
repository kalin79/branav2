<?php


namespace App\Http\Enums;


class TypeColorMarca extends Enum
{
    const GLORIA    = 11;
    const BONLE    = 12;
    const ACTIBIO     = 13;
    const PRO     = 14;
    const BATTIMIX    = 15;
    protected static $masterId = 3;

    public static function master()
    {
        return self::$masterId;
    }
}

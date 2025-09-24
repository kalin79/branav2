<?php


namespace App\Http\Enums;


class TypeRegistroImages extends Enum
{
    const PRODUCTO    = 1;
    const CAMPANA     = 2;
    const VIDEO     = 3;
    protected static $masterId = 1;

    public static function master()
    {
        return self::$masterId;
    }
}

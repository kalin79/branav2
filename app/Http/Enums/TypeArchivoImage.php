<?php


namespace App\Http\Enums;


class TypeArchivoImage extends Enum
{
    const ARCHIVO    = 4;
    const URL     = 5;
    protected static $masterId = 2;

    public static function master()
    {
        return self::$masterId;
    }
}

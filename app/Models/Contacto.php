<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $table = 'contactos';

    protected $fillable = [
        'nombre_apellidos',
        'correo',
        'nro_celular',
        'asunto',
        'mensaje',
        'tyc',
    ];
}

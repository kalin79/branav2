<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reclamacion extends Model
{
    protected $table = 'reclamacions';

    protected $fillable = [
        'nombres',
        'apellidos',
        'tipo_documento',
        'nro_documento',
        'nro_celular',
        'correo_electronico',
        'producto',
        'nro_pedido',
        'descripcion_bien',
        'tipo',
        'detalle',
        'pedido',
        'tyc',
    ];
}

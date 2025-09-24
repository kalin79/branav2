<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupones extends Model
{
    use HasFactory;
    protected $table = 'cupones';
    protected $fillable = [
        'codigo', 'monto','fecha_inicio','fecha_fin','cantidad','usuario_asociado','tipo', 'estado','created_user_id','updated_user_id','deleted_user_id'
    ];
}

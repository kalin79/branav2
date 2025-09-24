<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Traits\Audit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clientes extends Authenticatable implements JWTSubject
{
    use HasFactory;
    use Audit;
    use SoftDeletes;
    use QueryFilter;

    protected $table = 'clientes';
    protected $fillable = [
        'nombres',
        'apellidos',
        'fecha_nacimiento',
        'tipo_documento',
        'nro_documento',
        'celular',
        'email',
        'direccion',
        'departamento_id',
        'provincia_id',
        'distrito_id',
        'password',
        'tyc',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id'
    ];

    protected $hidden = ['password'];

    public function getFechaRegistroAttribute()
    {
        return date("Y-m-d", strtotime($this->created_at));
    }

    public function getFullNameAttribute()
    {
        return $this->nombres . " " . $this->apellido_paterno;
    }

    // Métodos requeridos por JWTSubject
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

}


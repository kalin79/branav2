<?php

namespace App\Models;

use App\Http\Filters\QueryFilter;
use App\Traits\Audit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoRelacionados extends Model
{
    use HasFactory;
    use SoftDeletes;
    use QueryFilter;
    use Audit;
    protected $table = 'productos_relacionados';
    protected $fillable = ['producto_id','producto_relacionado_id','active','created_user_id','updated_user_id','deleted_user_id'];
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';
    protected $dates = ['deleted_at'];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'producto_id' => 'integer',
        'producto_relacionado_id' => 'integer',

    ];

    //var $category = null;

    public static function storeValidation($request)
    {
        return [


        ];
    }

    public static function updateValidation($request)
    {
        return [


        ];
    }

    public static function attributesValidation()
    {
        return [

        ];
    }

    public function scopeActivos($query)
    {
        return $query->where('active', 1);
    }

    public function producto(){
        return $this->belongsTo(Productos::class,'producto_relacionado_id');
    }
}

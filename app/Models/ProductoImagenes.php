<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductoImagenes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'producto_imagenes';

    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';


    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'producto_id', 'image', 'order'
    ];

    public static function reorder($product_id){
        $gallery = self::where('producto_id',$product_id)->orderby('order', 'asc')->get();
        $min = $gallery->min('order');
        $ids = $gallery->pluck('id')->toArray();
        $min = $min === 0 ? 1 : $min;

        foreach ($gallery as $image) {
            $key = array_search($image->id, $ids);
            if (!is_bool($key)) {
                $image->order = $min + $key;
                $image->save();
            }
        }
    }
}

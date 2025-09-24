<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sale_products';

    protected $fillable = [
        'sale_id',
        'product_id',
        'product_name',
        'product_code',
        'product_description',
        'product_image',
        'price_type',
        'unit_price',
        'total_price',
        'quantity',
        'status',
        'detail',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    protected $casts = [
        'unit_price'   => 'decimal:2',
        'total_price'  => 'decimal:2',
    ];

    /**
     * Relaciones
     */
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function product()
    {
        return $this->belongsTo(Productos::class);
    }
}

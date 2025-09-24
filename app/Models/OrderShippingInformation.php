<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderShippingInformation extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'order_shipping_informations';

    protected $fillable = [
        'name',
        'surname',
        'nro_documento',
        'cell_phone',
        'direction',
        'reference',
        'district_id',
        'delivery',
        'postal_code',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];

    protected $casts = [
        'delivery' => 'decimal:2',
    ];

    /**
     * Relaciones
     */
    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class, 'order_shipping_information_id');
    }
}

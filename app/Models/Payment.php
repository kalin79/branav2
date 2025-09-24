<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Payment.php
class Payment extends Model
{
    protected $fillable = [
        'sale_id','payment_id','status','payment_type','transaction_amount','payload'
    ];

    protected $casts = ['payload' => 'array'];

    public function sale() {
        return $this->belongsTo(Sale::class);
    }
}

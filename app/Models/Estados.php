<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Estado extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'estados';

    protected $fillable = [
        'mstatus_id',
        'nombre',
        'abbreviation',
        'level',
        'created_user_id',
        'updated_user_id',
        'deleted_user_id',
    ];
}

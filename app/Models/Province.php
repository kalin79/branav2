<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function districts()
    {
        return $this->hasMany(District::class);
    }

}

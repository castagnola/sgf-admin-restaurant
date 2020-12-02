<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tables extends Model
{
    public function bookings()
    {
       return $this->hasMany(Bookings::class,'id_mesa','id');
    }

    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class,'id');
    }
}

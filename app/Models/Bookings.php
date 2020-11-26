<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookings extends Model
{
    protected $table ='bookings';

    public function tables()
    {
        return $this->hasOne(Tables::class,'id','id_mesa');

    }
}

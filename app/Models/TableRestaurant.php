<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableRestaurant extends Model
{
    protected $table ='table_restaurant';

    public function tables()
    {
        return $this->belongsTo(Tables::class,'id_mesa');
    }
}



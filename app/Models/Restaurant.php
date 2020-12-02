<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $table ='restaurants';

    /**
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cities()
    {
        return $this->hasOne(Cities::class,'id','id_ciudad');
    }

    /**
     * Retorna las mesas asociadas al restaurante
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tables_restaurant()
    {
        return $this->hasMany(TableRestaurant::class,'id_restaurante','id');
    }




}

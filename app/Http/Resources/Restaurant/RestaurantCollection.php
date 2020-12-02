<?php

namespace App\Http\Resources\Restaurant;

use App\Http\Resources\City\CityCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class RestaurantCollection extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'direccion' => $this->direccion,
            'url_foto' => $this->url_foto,
            'city' => new CityCollection($this->city),
            'tables_restaurant' => new CityCollection($this->city)
        ];
    }
}

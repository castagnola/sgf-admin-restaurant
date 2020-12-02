<?php

namespace App\Http\Resources\TableRestaurant;

use App\Http\Resources\Restaurant\RestaurantCollection;
use App\Http\Resources\Table\TableCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class TableRestaurantCollection extends JsonResource
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
            'restaurant' => new RestaurantCollection($this->id_restaurante),
            'table' => new TableCollection($this->table)
        ];
    }
}

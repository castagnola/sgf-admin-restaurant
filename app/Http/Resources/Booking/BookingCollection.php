<?php

namespace App\Http\Resources\Booking;

use App\Http\Resources\Table\TableCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingCollection extends JsonResource
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
            'nombre_comensal' => $this->nombre_comensal,
            'fecha_reserva' => $this->fecha_reserva,
            'comentarios' => $this->comentarios,
            'mesas'=> new TableCollection($this->mesas)
        ];
    }
}

<?php

namespace App\Http\Resources\Table;

use Illuminate\Http\Resources\Json\JsonResource;

class TableCollection extends JsonResource
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
            'numero_mesa' => $this->numero_mesa,
            'puestos' => $this->puestos,
            'disponible' => $this->disponible,
        ];
    }
}

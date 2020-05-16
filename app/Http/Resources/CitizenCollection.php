<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class CitizenCollection extends JsonResource
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
            "name" => $this->name,
            "email" => $this->email,
            "country_name" => $this->country->name,
            "citizen_info" => [
                route("citizens.show", [$this->country_id, $this->id])
            ]
        ];
    }
}

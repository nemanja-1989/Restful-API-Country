<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class NumberCollection extends JsonResource
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
            "citizen" => $this->citizen->name,
            "number" => $this->number,
            "number_info" => [
                route("numbers.show", [$this->citizen_id, $this->id])
            ]
        ];
    }
}

<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "identifier" => $this->id,
            "name" => $this->name,
            "image" => $this->image,
            "created" => $this->created_at->diffForHumans(),
            "updated" => $this->updated_at->diffForHumans()
        ];
    }
}

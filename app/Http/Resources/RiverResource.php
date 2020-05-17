<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RiverResource extends JsonResource
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
            "river_identifier" => $this->id,
            "river_name" => $this->name,
            "river_length" => $this->length,
            "river_size" => $this->size,
            "river_coordinates" => $this->coordinates,
            "river_first_image" => $this->image1,
            "river_second_image" => $this->image2,
            "river_third_image" => $this->image3,
            "river_description" => $this->description,
            "river_created" => $this->created_at->diffForHumans(),
            "river_updated" => $this->updated_at->diffForHumans()
        ];
    }
}

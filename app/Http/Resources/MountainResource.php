<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MountainResource extends JsonResource
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
            "mountain_indentifier" => $this->id,
            "mountain_name" => $this->name,
            "mountain_elevation" => $this->elevation,
            "mountain_promience" => $this->promience,
            "mountain_coordination" => $this->coordination,
            "mountain_isolation" => $this->isolation,
            "mountain_first_image" => $this->image1,
            "mountain_second_image" => $this->image2,
            "mountain_third_image" => $this->image3,
            "mountain_description" => $this->description,
            "mountain_created" => $this->created_at->diffForHumans(),
            "mountain_updated" => $this->created_at->diffForHumans()
        ];
    }
}

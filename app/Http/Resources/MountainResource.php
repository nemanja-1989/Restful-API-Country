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
            "name" => $this->name,
            "elevation" => $this->elevation,
            "promience" => $this->promience,
            "coordination" => $this->coordination,
            "isolation" => $this->isolation,
            "image1" => $this->image1,
            "image2" => $this->image2,
            "image3" => $this->image3,
            "description" => $this->description,
            "created" => $this->created_at->diffForHumans(),
            "updated" => $this->created_at->diffForHumans()
        ];
    }
}

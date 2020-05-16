<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CitizenResource extends JsonResource
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
            "country_name" => $this->country->name,
            "citizen_identifier" => $this->id,
            "name" => $this->name,
            "email" => $this->email,
            "status" => $this->status === 1 ? "Active" : "Inactive",
            "image" =>  $this->image,
            "created" => $this->created_at->diffForHumans(),
            "updated" => $this->updated_at->diffForHumans(),
        ];
        //dd($request);
    }
}

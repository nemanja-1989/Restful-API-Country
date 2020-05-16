<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NumberResource extends JsonResource
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
            "citizen" => $this->citizen->name,
            "citizen_email" => $this->citizen->email,
            "number_identifier" => $this->id,
            "number" => $this->number,
            "status" => $this->status === 1 ? "Active" : "Inactive",
            "created" => $this->created_at->diffForHumans(),
            "updated" => $this->updated_at->diffForHumans()
        ];
    }
}

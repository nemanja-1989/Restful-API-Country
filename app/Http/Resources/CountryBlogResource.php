<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CountryBlogResource extends JsonResource
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
            "country_blog_identifier" => $this->id,
            "country_name" => $this->name,
            "country_population" => $this->population,
            "country_area_code" => $this->area_code,
            "country_description" => $this->description,
            "country_image" => $this->image
        ];
    }
}

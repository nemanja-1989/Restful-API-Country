<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\DB;

class CountryCollection extends JsonResource
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
            "country_number" => collect(DB::table("countries AS co")->join("citizens AS ci", function($join) {
                $join->on("co.id", "=", "ci.country_id");
            })->join("numbers AS n", function($join) {
                $join->on("ci.id", "=", "n.citizen_id");
            })->select(DB::raw("`n`.`number`"))->get()),
            "name" => $this->name,
            "image" => $this->image,
            "link to country" => [
                route("countries.show", $this->id)
            ]
        ];
    }
}

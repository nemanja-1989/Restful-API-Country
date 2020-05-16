<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CountryBlog extends Model
{
    protected $fillable = [
        "citizen_id",
        "name",
        "population",
        "area_code",
        "about",
        "image"
    ];

    public function citizen() {
        return $this->belongsTo(Citizen::class);
    }
}

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

    public function mountains() {
        return $this->hasMany(Mountain::class);
    }

    public function rivers() {
        return $this->hasMany(River::class);
    }
}

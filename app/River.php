<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class River extends Model
{
    protected $fillable = [
        "country_blog_id",
        "name",
        "length",
        "size",
        "coordinates",
        "description",
        "image1",
        "image2",
        "image3"
    ];

    public function country_blog() {
        return $this->belongsTo(CountryBlog::class);
    }
}

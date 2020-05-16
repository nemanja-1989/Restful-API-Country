<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mountain extends Model
{
    protected $fillable = [
        "country_blog_id",
        "name",
        "description",
        "elevation",
        "promience",
        "coordination",
        "isolation",
        "image1",
        "image2",
        "image3"
    ];

    public function country_blog() {
        return $this->belongsTo(CountryBlog::class);
    }
}

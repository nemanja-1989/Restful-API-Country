<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        "name",
        "image"
    ];

    public function citizens() {
        return $this->hasMany(Citizen::class);
    }
}

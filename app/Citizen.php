<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Citizen extends Model
{
    protected $fillable = [
        "country_id",
        "name",
        "email",
        "password",
        "status",
        "image"
    ];

    public function country() {
        return $this->belongsTo(Country::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Number extends Model
{
    protected $fillable = [
        "citizen_id",
        "number",
        "status"
    ];

    public function citizen() {
        return $this->belongsTo(Citizen::class);
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

class Country extends Model
{
    use HasRelationships;

    protected $fillable = [
        "name",
        "image"
    ];

    public function citizens() {
        return $this->hasMany(Citizen::class);
    }

    public function mountains() {
        return $this->hasManyDeep(Mountain::class, [Citizen::class, CountryBlog::class]);
    }

    public function rivers() {
        return $this->hasManyDeep(River::class, [Citizen::class, CountryBlog::class]);
    }

    public function country_blogs() {
        return $this->hasManyThrough(CountryBlog::class, Citizen::class);
    }

    public function numbers() {
        return $this->hasManyThrough(Number::class, Citizen::class);
    }
}

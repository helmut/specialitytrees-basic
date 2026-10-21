<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Species extends Model
{
    protected $table = 'species';

    public function trees()
    {
        return $this->hasMany(Tree::class);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('name');
    }

    public function getUrlAttribute()
    {
        return url('/trees/species/' . $this->name_url);
    }
}

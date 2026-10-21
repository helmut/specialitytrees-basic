<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genus extends Model
{
    protected $table = 'genus';

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
        return url('/trees/genus/' . $this->name_url);
    }
}

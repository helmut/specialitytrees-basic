<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Family extends Model
{
    protected $table = 'families';

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
        return url('/trees/families/' . $this->name_url);
    }
}

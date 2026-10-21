<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Container extends Model
{
    public function scopeSorted($query)
    {
        return $query->orderBy('position');
    }
}

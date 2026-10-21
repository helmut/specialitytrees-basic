<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    public function scopeSorted($query)
    {
        return $query->orderBy('name');
    }
}

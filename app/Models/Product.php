<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    public function tree()
    {
        return $this->belongsTo(Tree::class);
    }

    public function container()
    {
        return $this->belongsTo(Container::class);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('container_id');
    }

    public function scopeExcludingBareroot($query)
    {
        return $query->whereHas('container', fn ($q) => $q->where('name', 'not like', '%Bareroot%'));
    }

    public function scopeAvailable($query)
    {
        return $query->where('available', 1);
    }

    public function getPriceAttribute()
    {
        return $this->wholesale_price;
    }
}

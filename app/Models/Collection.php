<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    public function items()
    {
        return $this->hasMany(CollectionItem::class)->orderBy('position');
    }

    public function trees()
    {
        return $this->belongsToMany(Tree::class, 'collection_items')->orderBy('position');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'model_id')
            ->where('model_type', 'App\\Collection')
            ->orderBy('order_column');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('name');
    }

    public function getUrlAttribute(): string
    {
        return url('/collections/' . $this->name_url . '-' . $this->hash);
    }

    public function getPhotoAttribute(): ?Media
    {
        return $this->media->first();
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->photo?->getUrl('thumbnail');
    }
}

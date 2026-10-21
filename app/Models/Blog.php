<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class, 'blog_blog_category');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'model_id')
            ->where('model_type', 'App\\Blog')
            ->orderBy('order_column');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSorted($query)
    {
        return $query->orderByDesc('date');
    }

    public function getUrlAttribute(): string
    {
        return url('/blog/' . $this->name_url . '-' . $this->hash);
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->media->first()?->getUrl('thumbnail');
    }
}

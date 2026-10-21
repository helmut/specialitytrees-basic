<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tree extends Model
{
    // --- Relationships ---

    public function genus()
    {
        return $this->belongsTo(Genus::class);
    }

    public function species()
    {
        return $this->belongsTo(Species::class);
    }

    public function family()
    {
        return $this->belongsTo(Family::class);
    }

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function height()
    {
        return $this->belongsTo(Height::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->orderBy('name');
    }

    public function products()
    {
        return $this->hasMany(Product::class)
            ->whereHas('container', fn ($q) => $q->where('name', 'not like', '%Bareroot%'))
            ->orderBy('container_id');
    }

    public function media()
    {
        return $this->hasMany(Media::class, 'model_id')
            ->where('model_type', 'App\\Tree')
            ->orderBy('order_column');
    }

    public function collections()
    {
        return $this->belongsToMany(Collection::class, 'collection_items')
            ->where('collections.active', 1)
            ->orderBy('collections.name');
    }

    // --- Scopes ---

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeSorted($query)
    {
        return $query->orderBy('name');
    }

    public function scopeMatchingSlug($query, $slug)
    {
        $parts = explode('-', $slug);
        $hash = array_pop($parts);
        $name_url = implode('-', $parts);

        return $query->where(function ($q) use ($hash, $name_url, $slug) {
            $q->where('hash', $hash)
              ->orWhere('name_url', $name_url)
              ->orWhere('name_url', $slug);
        });
    }

    public function scopeMatchingTerm($query, $term)
    {
        if (! strlen($term)) return $query;

        return $query->where(function ($q) use ($term) {
            $q->where('name', 'like', '%' . $term . '%')
              ->orWhere('name_clean', 'like', '%' . $term . '%')
              ->orWhere('common', 'like', '%' . $term . '%')
              ->orWhere('common_clean', 'like', '%' . $term . '%');
        });
    }

    public function scopeStartsWith($query, $letter)
    {
        if (! $letter) return $query;
        return $query->where('name', 'like', $letter . '%')
                     ->orWhere('name', 'like', strtoupper($letter) . '%');
    }

    public function scopeInHeights($query, array $heights)
    {
        if (empty($heights)) return $query;
        return $query->whereIn('height_id', $heights);
    }

    public function scopeInCategories($query, array $categories)
    {
        if (empty($categories)) return $query;
        return $query->whereHas('categories', fn ($q) => $q->whereIn('categories.id', $categories));
    }

    public function scopeInForm($query, $form)
    {
        if (! $form) return $query;
        return $query->where('form_id', $form);
    }

    public function scopeAvailability($query, $availability)
    {
        if ($availability === 'available') {
            return $query->whereHas('products', fn ($q) => $q->where('available', 1));
        }
        if ($availability === 'production') {
            return $query->has('products');
        }
        return $query;
    }

    // --- Accessors ---

    public function getSlugAttribute(): string
    {
        return $this->name_url . '-' . $this->hash;
    }

    public function getUrlAttribute(): string
    {
        return url('/trees/' . $this->slug);
    }

    public function getPhotoAttribute(): ?Media
    {
        return $this->media->where('collection_name', 'photos')->first();
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->photo?->getUrl('thumbnail');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo?->getUrl('small');
    }

    public function getBackgroundUrlAttribute(): ?string
    {
        return $this->photo?->getUrl('background');
    }

    public function getFoliageAttribute(): ?Category
    {
        return $this->categories->whereIn('name', ['Evergreen', 'Deciduous'])->first();
    }

    public function getNameWithCommonAttribute(): string
    {
        return $this->common
            ? $this->name . ' — ' . $this->common
            : $this->name;
    }
}

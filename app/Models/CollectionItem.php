<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    protected $table = 'collection_items';

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function tree()
    {
        return $this->belongsTo(Tree::class);
    }
}

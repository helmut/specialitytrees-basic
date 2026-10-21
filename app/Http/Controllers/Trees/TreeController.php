<?php

namespace App\Http\Controllers\Trees;

use App\Http\Controllers\Controller;
use App\Models\Tree;

class TreeController extends Controller
{
    public function show(string $slug)
    {
        $tree = Tree::matchingSlug($slug)
            ->with(['media', 'family', 'form', 'categories', 'height', 'genus', 'species', 'products.container', 'collections'])
            ->active()
            ->first();

        if (! $tree) {
            abort(404);
        }

        // Canonical redirect
        if (request()->path() !== 'trees/' . $tree->slug) {
            return redirect(url('/trees/' . $tree->slug), 301);
        }

        $similar = Tree::active()
            ->where('id', '!=', $tree->id)
            ->where(function ($q) use ($tree) {
                if ($tree->height_id) $q->where('height_id', $tree->height_id);
            })
            ->whereHas('categories', fn ($q) =>
                $q->whereIn('categories.id', $tree->categories->pluck('id'))
            )
            ->with(['media', 'height', 'products.container'])
            ->sorted()
            ->limit(6)
            ->get();

        return view('trees.show', compact('tree', 'similar'));
    }
}

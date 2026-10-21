<?php

namespace App\Http\Controllers;

use App\Models\Tree;
use App\Models\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $featured = Tree::active()
            ->whereHas('media')
            ->with(['media', 'height', 'categories', 'products.container'])
            ->inRandomOrder()
            ->limit(6)
            ->get();

        $collections = Collection::active()->sorted()->with('media')->limit(4)->get();

        return view('home', compact('featured', 'collections'));
    }
}

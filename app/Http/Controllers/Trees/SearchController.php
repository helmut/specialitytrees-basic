<?php

namespace App\Http\Controllers\Trees;

use App\Http\Controllers\Controller;
use App\Models\Tree;
use App\Models\Height;
use App\Models\Category;
use App\Models\Form;

class SearchController extends Controller
{
    public function index()
    {
        $heights = Height::sorted()->get();
        $categories = Category::sorted()->get();
        $forms = Form::sorted()->get();
        $letters = range('a', 'z');

        $availability = request('availability', 'all');
        $term = request('term', '');
        $selectedHeights = array_filter((array) request('heights', []), 'is_numeric');
        $selectedCategories = array_filter((array) request('categories', []), 'is_numeric');
        $form = (int) request('form', 0) ?: null;
        $letter = request('letter', '');
        if ($letter && ! in_array($letter, $letters)) $letter = '';

        $trees = Tree::query()
            ->with(['media', 'family', 'form', 'categories', 'height', 'products.container'])
            ->active()
            ->availability($availability)
            ->matchingTerm($term)
            ->inHeights(array_map('intval', $selectedHeights))
            ->inCategories(array_map('intval', $selectedCategories))
            ->inForm($form)
            ->startsWith($letter)
            ->sorted()
            ->paginate(48)
            ->withQueryString();

        return view('trees.index', compact(
            'trees', 'heights', 'categories', 'forms', 'letters',
            'availability', 'term', 'selectedHeights', 'selectedCategories', 'form', 'letter'
        ));
    }
}

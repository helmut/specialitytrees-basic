@extends('layouts.app')

@section('title', 'Trees')
@section('description', 'Browse our full range of premium quality advanced landscaping trees and screens.')

@section('content')

<div class="bg-dark text-white py-4">
    <div class="container">
        <h1 class="mb-0">Trees</h1>
        <p class="text-white-50 mb-0 mt-1">{{ $trees->total() }} tree{{ $trees->total() !== 1 ? 's' : '' }} found</p>
    </div>
</div>

<div class="container py-4" x-data="{ filtersOpen: false }">
    <div class="row g-4">

        {{-- Filter sidebar --}}
        <div class="col-lg-3">
            <div class="d-flex justify-content-between align-items-center d-lg-none mb-2">
                <button class="btn btn-outline-secondary btn-sm" @click="filtersOpen = !filtersOpen">
                    <i class="fas fa-filter me-1"></i> Filters
                </button>
                @if(request()->hasAny(['term','availability','heights','categories','form','letter']))
                <a href="{{ url('/trees') }}" class="btn btn-sm btn-outline-danger">Clear filters</a>
                @endif
            </div>

            <div class="card" x-show="filtersOpen || window.innerWidth >= 992" x-cloak>
                <div class="card-body">
                    <form method="GET" action="{{ url('/trees') }}" id="filter-form">

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Search</label>
                            <div class="input-group input-group-sm">
                                <input type="text" name="term" class="form-control" value="{{ $term }}" placeholder="Tree name...">
                                <button class="btn btn-primary" type="submit"><i class="fas fa-search"></i></button>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Availability</label>
                            <select name="availability" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="all" {{ $availability === 'all' ? 'selected' : '' }}>All trees</option>
                                <option value="available" {{ $availability === 'available' ? 'selected' : '' }}>Available now</option>
                                <option value="production" {{ $availability === 'production' ? 'selected' : '' }}>In production</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Mature Height</label>
                            @foreach($heights as $h)
                            <div class="form-check form-check-sm">
                                <input class="form-check-input" type="checkbox" name="heights[]" value="{{ $h->id }}"
                                    id="height_{{ $h->id }}" {{ in_array($h->id, $selectedHeights) ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <label class="form-check-label small" for="height_{{ $h->id }}">{{ $h->name }}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Category</label>
                            @foreach($categories as $cat)
                            <div class="form-check form-check-sm">
                                <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $cat->id }}"
                                    id="cat_{{ $cat->id }}" {{ in_array($cat->id, $selectedCategories) ? 'checked' : '' }}
                                    onchange="this.form.submit()">
                                <label class="form-check-label small" for="cat_{{ $cat->id }}">{{ $cat->name }}</label>
                            </div>
                            @endforeach
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Form</label>
                            <select name="form" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="">Any</option>
                                @foreach($forms as $f)
                                <option value="{{ $f->id }}" {{ $form === $f->id ? 'selected' : '' }}>{{ $f->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Browse A–Z</label>
                            <div class="d-flex flex-wrap gap-1">
                                <a href="{{ url('/trees') }}?{{ http_build_query(array_merge(request()->except('letter'), ['letter' => ''])) }}"
                                   class="btn btn-xs btn-{{ !$letter ? 'primary' : 'outline-secondary' }} p-1 lh-1" style="font-size:0.7rem">All</a>
                                @foreach($letters as $l)
                                <a href="{{ url('/trees') }}?{{ http_build_query(array_merge(request()->except('letter', 'page'), ['letter' => $l])) }}"
                                   class="btn btn-xs btn-{{ $letter === $l ? 'primary' : 'outline-secondary' }} p-1 lh-1" style="font-size:0.7rem">{{ strtoupper($l) }}</a>
                                @endforeach
                            </div>
                        </div>

                        @if(request()->hasAny(['term','availability','heights','categories','form','letter']))
                        <a href="{{ url('/trees') }}" class="btn btn-sm btn-outline-danger w-100 d-none d-lg-block">Clear all filters</a>
                        @endif

                    </form>
                </div>
            </div>
        </div>

        {{-- Results --}}
        <div class="col-lg-9">
            @if($trees->isEmpty())
            <div class="text-center py-5">
                <i class="fas fa-tree fa-3x text-secondary mb-3"></i>
                <h4>No trees found</h4>
                <p class="text-muted">Try adjusting your filters.</p>
                <a href="{{ url('/trees') }}" class="btn btn-primary">Clear filters</a>
            </div>
            @else
            <div class="row g-3">
                @foreach($trees as $tree)
                    @include('components.tree-card', ['tree' => $tree])
                @endforeach
            </div>

            <div class="mt-4">
                {{ $trees->links() }}
            </div>
            @endif
        </div>

    </div>
</div>

@endsection

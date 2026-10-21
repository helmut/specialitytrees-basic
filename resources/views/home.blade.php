@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="bg-dark text-white py-5">
    <div class="container py-3">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold">Premium Quality Advanced Landscaping Trees</h1>
                <p class="lead">Specialists in the environmentally sustainable production of advanced landscaping trees and screens.</p>
                <a href="{{ url('/trees') }}" class="btn btn-primary btn-lg me-2">Browse Trees</a>
                <a href="{{ url('/about') }}" class="btn btn-outline-light btn-lg">About Us</a>
            </div>
        </div>
    </div>
</div>

@if($collections->count())
<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Collections</h2>
        <div class="row g-4">
            @foreach($collections as $collection)
            <div class="col-md-6 col-lg-3">
                <a href="{{ $collection->url }}" class="text-decoration-none text-dark">
                    <div class="card h-100 shadow-sm">
                        @if($collection->thumbnailUrl)
                        <img src="{{ $collection->thumbnailUrl }}" class="card-img-top" alt="{{ $collection->name }}" style="height:180px;object-fit:cover">
                        @else
                        <div class="bg-secondary" style="height:180px"></div>
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $collection->name }}</h5>
                            <p class="card-text small text-muted">{{ Str::limit($collection->description, 100) }}</p>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="mt-4">
            <a href="{{ url('/collections') }}" class="btn btn-outline-secondary">View all collections</a>
        </div>
    </div>
</section>
@endif

@if($featured->count())
<section class="bg-light py-5">
    <div class="container">
        <h2 class="mb-4">Featured Trees</h2>
        <div class="row g-4">
            @foreach($featured as $tree)
                @include('components.tree-card', ['tree' => $tree])
            @endforeach
        </div>
        <div class="mt-4">
            <a href="{{ url('/trees') }}" class="btn btn-primary">Browse all trees</a>
        </div>
    </div>
</section>
@endif

<section class="py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2>For more than {{ date('Y') - 1977 }} years</h2>
                <p class="lead">Speciality Trees has been a leader in the production and supply of advanced environmentally sustainable, containerised landscape trees for local government, the landscaping industry and retailers.</p>
                <a href="{{ url('/about') }}" class="btn btn-primary">Learn more about us</a>
            </div>
        </div>
    </div>
</section>

@endsection

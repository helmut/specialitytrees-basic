@extends('layouts.app')

@section('title', $tree->common ? $tree->name . ' — ' . $tree->common : $tree->name)
@section('description', Str::limit(strip_tags($tree->description), 160))

@section('content')

{{-- Hero --}}
<div class="py-4 bg-dark text-white" @if($tree->backgroundUrl) style="background-image:url('{{ $tree->backgroundUrl }}');background-size:cover;background-position:center" @endif>
    <div class="container" style="background:rgba(0,0,0,0.5);padding:1.5rem;border-radius:0.5rem">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-2">
                <li class="breadcrumb-item"><a href="{{ url('/trees') }}" class="text-white-50">Trees</a></li>
                <li class="breadcrumb-item active text-white">{{ $tree->name }}</li>
            </ol>
        </nav>
        <h1 class="mb-1"><em>{{ $tree->name }}</em></h1>
        @if($tree->common)
        <p class="lead mb-0 text-white-50">{{ $tree->common }}</p>
        @endif
    </div>
</div>

<div class="container py-5">
    <div class="row g-5">

        {{-- Image column --}}
        <div class="col-md-5">
            @php
                $photos = $tree->media->where('collection_name', 'photos');
            @endphp
            @if($photos->count())
            <div x-data="{ active: 0 }">
                @foreach($photos as $i => $photo)
                <img src="{{ $photo->getUrl('small') }}"
                     x-show="active === {{ $i }}"
                     class="img-fluid rounded shadow-sm w-100 mb-2"
                     alt="{{ $tree->name }}"
                     style="max-height:500px;object-fit:cover">
                @endforeach
                @if($photos->count() > 1)
                <div class="d-flex flex-wrap gap-2 mt-2">
                    @foreach($photos as $i => $photo)
                    <img src="{{ $photo->getUrl('thumbnail') }}"
                         @click="active = {{ $i }}"
                         class="rounded border"
                         style="width:60px;height:60px;object-fit:cover;cursor:pointer"
                         alt="">
                    @endforeach
                </div>
                @endif
            </div>
            @else
            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height:400px">
                <i class="fas fa-tree fa-5x text-secondary"></i>
            </div>
            @endif
        </div>

        {{-- Details column --}}
        <div class="col-md-7">

            {{-- Availability / products --}}
            @if($tree->products->count())
            <div class="mb-4">
                <h5 class="mb-3">Available Sizes</h5>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Container</th>
                                <th>Height</th>
                                <th>Price (ex GST)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($tree->products as $product)
                            <tr>
                                <td>{{ $product->container->name ?? '—' }}</td>
                                <td>{{ $product->height ?? '—' }}</td>
                                <td>{{ $product->wholesale_price ?? '—' }}</td>
                                <td>
                                    @if($product->available)
                                    <span class="badge bg-success">Available</span>
                                    @elseif($product->available_date)
                                    <span class="badge bg-warning text-dark">{{ \Carbon\Carbon::parse($product->available_date)->format('M Y') }}</span>
                                    @else
                                    <span class="badge bg-secondary">Unavailable</span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="small text-muted">To place an order, please <a href="{{ url('/contact') }}">contact us</a>.</p>
            </div>
            @else
            <div class="alert alert-light mb-4">
                <i class="fas fa-info-circle me-1"></i> Availability information not currently listed. <a href="{{ url('/contact') }}">Contact us</a> to enquire.
            </div>
            @endif

            {{-- Classification badges --}}
            <div class="d-flex flex-wrap gap-2 mb-4">
                @if($tree->foliage)
                <span class="badge bg-dark fs-6">{{ $tree->foliage->name }}</span>
                @endif
                @if($tree->height)
                <span class="badge bg-secondary fs-6">{{ $tree->height->name }}</span>
                @endif
                @if($tree->form)
                <span class="badge bg-secondary fs-6">{{ $tree->form->name }}</span>
                @endif
                @foreach($tree->categories->whereNotIn('name', ['Evergreen','Deciduous']) as $cat)
                <span class="badge bg-light text-dark border">{{ $cat->name }}</span>
                @endforeach
            </div>

            {{-- Description --}}
            @if($tree->description)
            <div class="mb-4">
                <h5>Description</h5>
                <p>{{ $tree->description }}</p>
            </div>
            @endif

            {{-- Uses --}}
            @if($tree->uses)
            <div class="mb-4">
                <h5>Uses</h5>
                <p>{{ $tree->uses }}</p>
            </div>
            @endif

            {{-- Position & Soil --}}
            @if($tree->position_and_soil)
            <div class="mb-4">
                <h5>Position &amp; Soil</h5>
                <p>{{ $tree->position_and_soil }}</p>
            </div>
            @endif

            {{-- Taxonomy --}}
            <div class="card bg-light mb-4">
                <div class="card-body small">
                    <h6 class="card-title">Classification</h6>
                    <dl class="row mb-0">
                        @if($tree->family)
                        <dt class="col-sm-4">Family</dt>
                        <dd class="col-sm-8"><a href="{{ url('/trees/families/'.$tree->family->name_url) }}">{{ $tree->family->name }}</a></dd>
                        @endif
                        @if($tree->genus)
                        <dt class="col-sm-4">Genus</dt>
                        <dd class="col-sm-8"><a href="{{ url('/trees/genus/'.$tree->genus->name_url) }}"><em>{{ $tree->genus->name }}</em></a></dd>
                        @endif
                        @if($tree->species)
                        <dt class="col-sm-4">Species</dt>
                        <dd class="col-sm-8"><a href="{{ url('/trees/species/'.$tree->species->name_url) }}"><em>{{ $tree->species->name }}</em></a></dd>
                        @endif
                        @if($tree->mature_size)
                        <dt class="col-sm-4">Mature size</dt>
                        <dd class="col-sm-8">{{ $tree->mature_size }}</dd>
                        @endif
                    </dl>
                </div>
            </div>

        </div>
    </div>

    {{-- Similar trees --}}
    @if($similar->count())
    <div class="mt-5">
        <h3 class="mb-4">Similar Trees</h3>
        <div class="row g-3">
            @foreach($similar as $tree)
                @include('components.tree-card', ['tree' => $tree])
            @endforeach
        </div>
    </div>
    @endif

</div>

@endsection

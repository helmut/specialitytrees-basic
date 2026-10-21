<div class="col-md-6 col-lg-4">
    <a href="{{ $tree->url }}" class="text-decoration-none text-dark">
        <div class="card h-100 shadow-sm">
            @if($tree->thumbnailUrl)
            <img src="{{ $tree->thumbnailUrl }}" class="card-img-top" alt="{{ $tree->name }}" style="height:200px;object-fit:cover">
            @else
            <div class="bg-light d-flex align-items-center justify-content-center" style="height:200px">
                <i class="fas fa-tree fa-3x text-secondary"></i>
            </div>
            @endif
            <div class="card-body">
                <h6 class="card-title mb-0"><em>{{ $tree->name }}</em></h6>
                @if($tree->common)
                <p class="text-muted small mb-1">{{ $tree->common }}</p>
                @endif
                <div class="d-flex gap-1 flex-wrap mt-2">
                    @if($tree->foliage)
                    <span class="badge bg-secondary">{{ $tree->foliage->name }}</span>
                    @endif
                    @if($tree->height)
                    <span class="badge bg-light text-dark border">{{ $tree->height->name }}</span>
                    @endif
                    @if($tree->products->where('available', 1)->count())
                    <span class="badge bg-success">Available</span>
                    @endif
                </div>
            </div>
        </div>
    </a>
</div>

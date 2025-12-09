<div class="card h-100">
    @if ($product->image)
        <img src="{{ asset($product->image) }}" class="card-img-top" style="height:300px; width: 250px;margin:20px"
            alt="{{ $product->name }}">
    @else
        <img src="https://via.placeholder.com/400x200?text=Flower" class="card-img-top"
            style="height:180px;object-fit:cover" alt="{{ $product->name }}">
    @endif
    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text text-muted mb-2">{{ Str::limit($product->description, 100) }}</p>
        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center">
                <div class="fw-bold">${{ number_format($product->price, 2) }}</div>
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-primary">View</a>
            </div>
        </div>
    </div>
</div>

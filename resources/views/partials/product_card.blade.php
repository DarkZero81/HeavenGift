<div class="card product-card h-100">
    @if ($product->image)
        <div class="product-image-container">
            <img src="{{ asset($product->image) }}" class="card-img-top" alt="{{ $product->name }}">
        </div>
    @else
        <div class="product-image-container">
            <img src="https://via.placeholder.com/400x300/667eea/ffffff?text={{ urlencode($product->name) }}"
                class="card-img-top" alt="{{ $product->name }}">
        </div>
    @endif

    <div class="card-body d-flex flex-column">
        <h5 class="card-title">{{ $product->name }}</h5>
        <p class="card-text">{{ Str::limit($product->description, 80) }}</p>

        <div class="mt-auto">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="price-tag">${{ number_format($product->price, 2) }}</div>
                @if ($product->old_price ?? false)
                    <div class="old-price">${{ number_format($product->old_price, 2) }}</div>
                @endif
            </div>

            <div class="d-grid gap-2">
                <a href="{{ route('products.show', $product->id) }}" class="btn btn-primary btn-card">
                    <i class="fas fa-eye me-2"></i>View Details
                </a>
                <button class="btn btn-outline-primary btn-card add-to-cart-btn">
                    <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    .product-card {
        background: rgba(255, 255, 255, 0.95);
        border: none;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(33, 150, 243, 0.1);
        transition: all 0.4s ease;
        overflow: hidden;
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 40px rgba(33, 150, 243, 0.2);
        border: 2px solid rgba(33, 150, 243, 0.3);
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #2196f3, #28a745, #2196f3);
        background-size: 200% 100%;
        animation: shimmer 3s ease-in-out infinite;
    }

    @keyframes shimmer {
        0% {
            background-position: -200% 0;
        }

        100% {
            background-position: 200% 0;
        }
    }

    .product-image-container {
        height: 280px;
        background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(40, 167, 69, 0.1) 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden;
        position: relative;
    }

    .product-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-image-container img {
        transform: scale(1.1);
    }

    .card-body {
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.98);
    }

    .card-title {
        color: #2196f3;
        font-weight: 700;
        font-size: 1.25rem;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .card-text {
        color: #6c757d;
        font-size: 0.95rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .price-tag {
        color: #28a745;
        font-size: 1.5rem;
        font-weight: 800;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
    }

    .old-price {
        color: #dc3545;
        font-size: 1rem;
        text-decoration: line-through;
        opacity: 0.7;
    }

    .btn-card {
        border-radius: 12px;
        font-weight: 600;
        padding: 0.75rem 1rem;
        transition: all 0.3s ease;
        border-width: 2px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.9rem;
    }

    .btn-primary.btn-card {
        background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        border-color: #2196f3;
        box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
    }

    .btn-primary.btn-card:hover {
        background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
    }

    .btn-outline-primary.btn-card {
        color: #2196f3;
        border-color: #2196f3;
        background: rgba(33, 150, 243, 0.05);
    }

    .btn-outline-primary.btn-card:hover {
        background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
        border-color: #2196f3;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
    }

    .btn-card i {
        font-size: 0.9rem;
    }

    @media (max-width: 768px) {
        .product-card {
            margin-bottom: 2rem;
        }

        .product-image-container {
            height: 250px;
        }

        .card-body {
            padding: 1.25rem;
        }
    }
</style>

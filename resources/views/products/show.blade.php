@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <style>
        /* From Uiverse.io by PriyanshuGupta28 */
        .rating {
            display: inline-block;
        }

        .rating input {
            display: none;
        }

        .rating label {
            float: right;
            cursor: pointer;
            color: #ccc;
            transition: color 0.3s;
        }

        .rating label:before {
            content: '\2605';
            font-size: 30px;
        }

        .rating input:checked~label,
        .rating label:hover,
        .rating label:hover~label {
            color: #6f00ff;
            transition: color 0.3s;
        }

        /* Unified Product Box Styling */
        .product-unified-box {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .product-image-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 1rem;
        }

        .product-image-unified {
            max-width: 300px;
            max-height: 300px;
            width: auto;
            height: auto;
            object-fit: contain;
            border-radius: 10px;
            border: 3px solid #007bff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background-color: #f8f9fa;
            padding: 10px;
        }

        .product-image-unified:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .product-image-unified {
            width: 300px;
            height: 300px;
            object-fit: cover;
            border-radius: 10px;
            border: 3px solid #007bff;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product-image-unified:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .product-info-section {
            padding: 1rem;
        }

        .product-title-unified {
            color: #2c3e50;
            font-weight: bold;
            margin-bottom: 1rem;
            font-size: 2rem;
        }

        .product-price-unified {
            color: #e74c3c;
            font-size: 2.5rem;
            font-weight: bold;
            margin: 1.5rem 0;
        }

        .product-description-unified {
            color: #666;
            line-height: 1.6;
            margin-bottom: 2rem;
            font-size: 1.1rem;
        }

        .purchase-section {
            background: #f8f9fa;
            padding: 1.5rem;
            border-radius: 10px;
            border: 2px dashed #dee2e6;
        }

        .quantity-selector {
            min-width: 120px;
        }

        .quantity-selector .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 0.5rem;
        }

        .quantity-selector .form-control {
            border: 2px solid #dee2e6;
            border-radius: 8px;
            text-align: center;
            font-weight: 600;
        }

        .quantity-selector .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }

        /* Review Section Enhancements */
        .reviews-section {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .reviews-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .review-item {
            border-bottom: 1px solid #eee;
            padding: 1.5rem;
            transition: background-color 0.3s ease;
        }

        .review-item:hover {
            background-color: #f8f9fa;
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .reviewer-info {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .reviewer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .rating-display {
            color: #ffc107;
            font-size: 1.1rem;
        }

        .comment-text {
            margin-left: 5%;
            color: #495057;
            line-height: 1.6;
            font-style: italic;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .product-image-unified {
                width: 250px;
                height: 250px;
            }

            .product-unified-box {
                padding: 1rem;
            }

            .product-info-section {
                padding: 0.5rem;
                margin-top: 1rem;
            }

            .product-title-unified {
                font-size: 1.5rem;
            }

            .product-price-unified {
                font-size: 2rem;
            }

            .purchase-section .d-flex {
                flex-direction: column;
                gap: 1rem;
            }

            .quantity-selector {
                min-width: 100%;
            }

            .reviewer-info {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }


        }
    </style>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="product-unified-box">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="product-image-section">
                            @if ($product->image)
                                @php $img = $product->image; @endphp
                                @if (filter_var($img, FILTER_VALIDATE_URL))
                                    <img src="{{ $img }}" class="product-image-unified" alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('storage/' . $img) }}" class="product-image-unified"
                                        alt="{{ $product->name }}">
                                @endif
                            @else
                                <img src="https://via.placeholder.com/300x300?text=Product" class="product-image-unified"
                                    alt="{{ $product->name }}">
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="product-info-section">
                            <h2 class="product-title-unified">{{ $product->name }}</h2>
                            <p class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</p>
                            <div class="product-price-unified">${{ number_format($product->price, 2) }}</div>
                            <p class="product-description-unified">{{ $product->description }}</p>

                            <div class="purchase-section">
                                <form action="{{ route('cart.add') }}" method="POST"
                                    class="d-flex align-items-center gap-3">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <div class="quantity-selector">
                                        <label class="form-label">Quantity:</label>
                                        <input type="number" name="quantity" value="1" min="1"
                                            class="form-control">
                                    </div>
                                    <button class="btn btn-success btn-lg px-4">
                                        <i class="bi bi-cart-plus"></i> Add to Cart
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="mt-5">
        <div class="reviews-section">
            <div class="reviews-header">
                <h4><i class="bi bi-star-fill"></i> Customer Rating & Reviews</h4>
            </div>
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        <h2 class="text-primary">{{ number_format($averageRating, 1) }}</h2>
                        <div class="rating-display mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                <i
                                    class="bi bi-star{{ $i <= floor($averageRating) ? '-fill' : ($i <= $averageRating ? '-half' : '') }}"></i>
                            @endfor
                        </div>
                        <p class="text-muted">Based on {{ $reviewsCount }} Ratings</p>
                    </div>
                    <div class="col-md-8">
                        @for ($i = 5; $i >= 1; $i--)
                            @php
                                $percentage = $reviewsCount > 0 ? ($ratingCounts[$i] / $reviewsCount) * 100 : 0;
                            @endphp
                            <div class="row align-items-center mb-2">
                                <div class="col-2">
                                    <small class="text-muted">{{ $i }} <i
                                            class="bi bi-star-fill text-warning"></i></small>
                                </div>
                                <div class="col-8">
                                    <div class="progress" style="height: 8px;" role="progressbar"
                                        aria-valuenow="{{ $percentage }}" aria-valuemin="0" aria-valuemax="100"
                                        aria-label="{{ $i }} star ratings - {{ number_format($percentage, 1) }}%">
                                        <div class="progress-bar bg-warning" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <small class="text-muted">({{ $ratingCounts[$i] }})</small>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>

                <div class="reviews-list">
                    @forelse($approvedReviews as $review)
                        <div class="review-item">
                            <div class="reviewer-info">
                                <div class="reviewer-avatar">
                                    {{ strtoupper(substr($review->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <div>
                                    <h6 class="mb-1" style="color: #2196f3">{{ $review->user->name ?? 'مستخدم محذوف' }}
                                    </h6>
                                    <div class="rating-display mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted ms-auto">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="comment-text">{{ $review->comment }}</div>
                        </div>
                    @empty
                        <p class="text-muted text-center">There Is No Comment Right Now.</p>
                    @endforelse
                </div>

                {{-- ⭐️ إضافة روابط ترقيم الصفحات هنا ⭐️ --}}
                <div class="d-flex justify-content-center mt-4">
                    {{ $approvedReviews->links() }}
                </div>
                {{-- --------------------------------- --}}

                @auth
                    <div class="mt-4 p-4" style="background: #f8f9fa; border-radius: 10px; border: 2px dashed #dee2e6;">
                        <h5 class="mb-3"><i class="bi bi-chat-square-text"></i> Add Your Rating</h5>
                        <form action="{{ route('reviews.store', $product) }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label class="form-label">Rating:</label>
                                <div class="rating-stars">
                                    @for ($i = 5; $i >= 1; $i--)
                                        <div class="rating">
                                            <input value="{{ $i }}" {{ $i == 5 ? 'checked' : '' }} name="rating"
                                                id="star{{ $i }}" type="radio">
                                            <label for="star{{ $i }}"></label>
                                        </div>
                                    @endfor
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="comment" class="form-label">Comment:</label>
                                <textarea name="comment" id="comment" class="form-control" rows="4"
                                    placeholder="Share your experience with this product..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-lg px-4">
                                <i class="bi bi-send"></i> Submit Review
                            </button>
                        </form>
                    </div>
                @else
                    <div class="alert alert-info">
                        <a href="{{ route('login') }}" class="alert-link"> Sign In</a> To Add You Comment .
                    </div>
                @endauth
            </div>
        </div>
    </section>

@endsection

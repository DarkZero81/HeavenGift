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
    </style>
    <div class="row mt-4">
        <div class="col-md-4">
            @if ($product->image)
                @php $img = $product->image; @endphp
                @if (filter_var($img, FILTER_VALIDATE_URL))
                    <img src="{{ $img }}" class="img-fluid" alt="{{ $product->name }}">
                @else
                    <img src="{{ asset('storage/' . $img) }}" class="img-fluid" alt="{{ $product->name }}">
                @endif
            @else
                <img src="https://via.placeholder.com/800x600?text=Product" class="img-fluid" alt="{{ $product->name }}">
            @endif
        </div>
        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->category->name ?? 'Uncategorized' }}</p>
            <h3 class="text-primary">${{ number_format($product->price, 2) }}</h3>
            <p>{{ $product->description }}</p>

            <form action="{{ route('cart.add') }}" method="POST" class="d-flex align-items-center">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="number" name="quantity" value="1" min="1" class="form-control me-2"
                    style="width:90px">
                <button class="btn btn-success">Add to cart</button>
            </form>
        </div>
    </div>

    <section class="mt-5 p-5">
        <div class="card">
            <div class="card-header">
                <h4>Customer Rating</h4>
            </div>
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-4 text-center">
                        <h2 class="text-primary">{{ number_format($averageRating, 1) }}</h2>
                        <div class="text-warning mb-2">
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
                        <div class="review-item border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $review->user->name ?? 'مستخدم محذوف' }}</h6>
                                    <div class="text-warning mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="mb-1">{{ $review->comment }}</p>
                                </div>
                                <small class="text-muted">{{ $review->created_at->diffForHumans() }}</small>
                            </div>
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
                    <div class="mt-4">
                        <h5>Add Your Rating</h5>
                        <form action="{{ route('reviews.store', $product) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Rating:</label>
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
                            <div class="form-group">
                                <label for="comment">Comment:</label>
                                <textarea name="comment" id="comment" class="form-control mt-2" rows="3"
                                    placeholder="شاركنا تجربتك مع هذا المنتج..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary mt-3">Send Rating</button>
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

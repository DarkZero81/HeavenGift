@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="hero-section p-4 rounded text-center text-md-start">
                <h1 id="title">Welcome to Gift Heaven</h1>
                <p class="lead">Fresh flowers delivered with love. Register now and receive a welcome coupon!</p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-warning text-dark">Register & Get Coupon</a>
                @else
                    <div class="alert alert-info">A welcome coupon has been issued to your account and will be auto-applied at
                        checkout.</div>
                @endguest
            </div>
        </div>
        <div class="col-md-4">
            <h5>Categories</h5>
            <ul class="list-group">
                @foreach (App\Models\Category::where('is_active', true)->get() as $cat)
                    <li class="list-group-item"><a
                            href="{{ route('products.index', ['category' => $cat->id]) }}">{{ $cat->name }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <h3>Featured Products</h3>
    <div class="row">
        @foreach (App\Models\Product::latest()->limit(6)->get() as $product)
            <div class="col-md-4 mb-4">
                @include('partials.product_card', ['product' => $product])
            </div>
        @endforeach
    </div>

    <!-- Hero / Carousel Section -->
    <section class="hero-section mt-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="carousel-container">
                        <div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel"
                            data-bs-interval="3000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <img src="{{ asset('Photo/ad-1.jpg') }}" class="d-block w-100" alt="Gift boxes">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('Photo/ad-2.jpg') }}" class="d-block w-100" alt="Birthday gifts">
                                </div>
                                <div class="carousel-item">
                                    <img src="{{ asset('Photo/ad-3.jpg') }}" class="d-block w-100" alt="Christmas gifts">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 text-center text-lg-start">
                    <h2 class="subtitle">Perfect Gifts for Every Occasion</h2>
                    <p class="lead mt-3">Discover unique and thoughtful gifts for birthdays, holidays, anniversaries, and
                        all of life's special moments.</p>
                    <div class="mt-4">
                        <a href="{{ route('products.index') }}" class="btn btn-lg btn-outline-warning">Shop Now</a>
                        <a href="{{ route('products.index') }}" class="btn btn-lg btn-outline-light ms-3">View Products</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

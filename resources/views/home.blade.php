@extends('layouts.app')

@section('title', 'Home')

@section('content')
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
                        <a href="{{ route('payment.now') }}" class="btn btn-lg btn-success ms-3">Quick Payment</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row mb-5">
        <div class="col-md-8">
            <div class="welcome-card">
                <div class="welcome-content">
                    <h1 id="title">Welcome to Gift Heaven</h1>
                    <p class="lead">Fresh flowers delivered with love. Register now and receive a welcome coupon!</p>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-welcome">
                            <i class="fas fa-gift me-2"></i>Register & Get Coupon
                        </a>
                    @else
                        <div class="alert alert-welcome">
                            <i class="fas fa-check-circle me-2"></i>
                            A welcome coupon has been issued to your account and will be auto-applied at checkout.
                        </div>
                    @endguest
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="categories-card">
                <div class="categories-header">
                    <h5><i class="fas fa-star me-2"></i>Famous Categories</h5>
                </div>
                <div class="categories-list">
                    @foreach (App\Models\Category::latest()->limit(5)->get() as $cat)
                        <a href="{{ route('products.index', ['category' => $cat->id]) }}" class="category-item">
                            <div class="category-info">
                                <i class="fas fa-tag category-icon"></i>
                                <span>{{ $cat->name }}</span>
                            </div>
                            <i class="fas fa-arrow-right category-arrow"></i>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="featured-section">
        <h3 class="featured-title">
            <i class="fas fa-gem me-3"></i>Featured Products
        </h3>
        <div class="row">
            @foreach (App\Models\Product::latest()->limit(3)->get() as $product)
                <div class="col-md-4 mb-4">
                    @include('partials.product_card', ['product' => $product])
                </div>
            @endforeach
        </div>
    </div>

    <style>
        /* Welcome Card Styling */
        .welcome-card {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.8) 100%);
            border-radius: 25px;
            padding: 3rem;
            box-shadow: 0 10px 30px rgba(33, 150, 243, 0.15);
            border: 2px solid rgba(33, 150, 243, 0.2);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #2196f3, #28a745, #2196f3);
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }

        .welcome-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(33, 150, 243, 0.2);
        }

        .welcome-content {
            position: relative;
            z-index: 2;
        }

        #title {
            background: linear-gradient(135deg, #2196f3 0%, #28a745 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            margin-bottom: 1.5rem;
            font-size: 2.5rem;
        }

        .lead {
            color: #495057;
            font-size: 1.2rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }

        .btn-welcome {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
        }

        .btn-welcome:hover {
            background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .alert-welcome {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%);
            border: 2px solid rgba(40, 167, 69, 0.3);
            color: #155724;
            border-radius: 15px;
            padding: 1.5rem;
            font-weight: 600;
        }

        /* Categories Card Styling */
        .categories-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(33, 150, 243, 0.1);
            border: 2px solid rgba(33, 150, 243, 0.2);
            transition: all 0.4s ease;
        }

        .categories-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(33, 150, 243, 0.15);
        }

        .categories-header {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .categories-header h5 {
            margin: 0;
            font-weight: 700;
            font-size: 1.2rem;
        }

        .categories-list {
            padding: 1rem 0;
        }

        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            text-decoration: none;
            color: #495057;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(33, 150, 243, 0.1);
        }

        .category-item:last-child {
            border-bottom: none;
        }

        .category-item:hover {
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.05) 0%, rgba(40, 167, 69, 0.05) 100%);
            color: #2196f3;
            transform: translateX(10px);
        }

        .category-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .category-icon {
            color: #28a745;
            font-size: 1rem;
            width: 20px;
            text-align: center;
        }

        .category-arrow {
            color: #2196f3;
            font-size: 0.9rem;
            transition: transform 0.3s ease;
        }

        .category-item:hover .category-arrow {
            transform: translateX(5px);
        }

        /* Featured Section Styling */
        .featured-section {
            margin-top: 3rem;
        }

        .featured-title {
            text-align: center;
            color: #2196f3;
            font-weight: 800;
            font-size: 2.2rem;
            margin-bottom: 3rem;
            position: relative;
            padding-bottom: 1rem;
        }

        .featured-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(90deg, #2196f3, #28a745);
            border-radius: 2px;
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        @media (max-width: 768px) {
            .welcome-card {
                padding: 2rem;
                margin-bottom: 2rem;
            }

            #title {
                font-size: 2rem;
            }

            .featured-title {
                font-size: 1.8rem;
            }

            .categories-card {
                margin-top: 2rem;
            }
        }
    </style>
@endsection

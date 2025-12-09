<nav class="navbar navbar-expand-lg navbar-dark bg-gradient shadow-sm">
    <div class="container">
        <!-- Brand Logo and Name -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <div class="brand-logo me-3">
                <i class="fas fa-gift fs-2 text-warning"></i>
            </div>
            <span class="brand-name fw-bold fs-3 text-white">Gift Heaven</span>
        </a>

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navigation Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Left Side - Main Navigation -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('products.index') ? 'active' : '' }}"
                        href="{{ route('products.index') }}">
                        <i class="fas fa-store me-2"></i>Shop
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        <i class="fas fa-envelope me-2"></i>Contact
                    </a>
                </li>
            </ul>

            <!-- Right Side - Search, User Menu, Cart -->
            <ul class="navbar-nav">
                <!-- Search Bar -->
                <li class="nav-item me-3">
                    <form class="d-flex search-form" role="search" action="{{ route('products.search') }}"
                        method="GET">
                        <div class="search-wrapper">
                            <input class="form-control search-input" name="query" type="search"
                                placeholder="Search products..." aria-label="Search" required>
                            <button class="search-btn" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </li>

                @guest
                    <!-- Guest User Menu -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2"></i>Register
                        </a>
                    </li>
                @else
                    <!-- Authenticated User Menu -->
                    @php
                        $u = auth()->user();
                        $avatarUrl = null;
                        if ($u) {
                            if (
                                !empty($u->profile_photo_url) &&
                                filter_var($u->profile_photo_url, FILTER_VALIDATE_URL)
                            ) {
                                $avatarUrl = $u->profile_photo_url;
                            } elseif (!empty($u->profile_photo_url)) {
                                $avatarUrl = \Illuminate\Support\Facades\Storage::url($u->profile_photo_url);
                            }
                        }

                        // Add cache busting for avatar
                        $avatarUrlWithVersion = null;
                        if (!empty($avatarUrl)) {
                            $ts = $u->updated_at ? $u->updated_at->timestamp : time();
                            $sep = strpos($avatarUrl, '?') !== false ? '&' : '?';
                            $avatarUrlWithVersion = $avatarUrl . $sep . 'v=' . $ts;
                        }
                    @endphp

                    <!-- User Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle user-dropdown" href="#" id="userDropdown" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar me-2">
                                @if ($avatarUrl)
                                    <img src="{{ $avatarUrlWithVersion ?? $avatarUrl }}" alt="User"
                                        class="rounded-circle" />
                                @else
                                    <div class="default-avatar">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <span class="user-name">{{ $u->name ?? 'User' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end user-dropdown-menu" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('userinfo') }}">
                                    <i class="fas fa-user-circle me-2"></i>Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="fas fa-cog me-2"></i>Settings
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none">
                            @csrf
                        </form>
                    </li>
                @endguest

                <!-- Cart -->
                <li class="nav-item">
                    <a class="nav-link nav-link-custom cart-link" href="{{ route('cart.index') }}">
                        <div class="cart-wrapper">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-badge">0</span>
                        </div>
                        <span class="ms-2">Cart</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <style>
        /* Custom Navbar Styles */
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand .brand-name {
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .nav-link-custom {
            color: rgba(255, 255, 255, 0.9) !important;
            padding: 0.75rem 1rem !important;
            border-radius: 8px;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #ffd700 !important;
            transform: translateY(-2px);
        }

        /* Search Form Styles */
        .search-form .search-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .search-input {
            width: 280px;
            max-width: 50vw;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 0.75rem 3rem 0.75rem 1.5rem;
            color: white;
            transition: all 0.3s ease;
        }

        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #ffd700;
            box-shadow: 0 0 0 0.2rem rgba(255, 215, 0, 0.25);
            outline: none;
        }

        .search-btn {
            position: absolute;
            right: 8px;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
            transition: all 0.3s ease;
        }

        .search-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 8px rgba(255, 215, 0, 0.3);
        }

        /* User Dropdown Styles */
        .user-dropdown {
            display: flex;
            align-items: center;
            padding: 0.5rem 1rem !important;
        }

        .user-avatar img {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border: 2px solid rgba(255, 255, 255, 0.3);
        }

        .default-avatar {
            width: 40px;
            height: 40px;
            background: linear-gradient(45deg, #ffd700, #ffed4e);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .user-dropdown-menu {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            margin-top: 0.5rem;
        }

        .user-dropdown-menu .dropdown-item {
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
        }

        .user-dropdown-menu .dropdown-item:hover {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
        }

        /* Cart Styles */
        .cart-link {
            position: relative;
            display: flex;
            align-items: center;
        }

        .cart-wrapper {
            position: relative;
            display: inline-block;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            color: white;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Mobile Responsive */
        @media (max-width: 991px) {
            .search-input {
                width: 200px;
            }

            .navbar-nav {
                margin-top: 1rem;
            }

            .nav-link-custom {
                margin: 0.25rem 0;
            }
        }

        @media (max-width: 576px) {
            .search-input {
                width: 150px;
            }

            .brand-name {
                font-size: 1.25rem !important;
            }
        }

        /* Animation for active state */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .nav-link-custom.active {
            animation: fadeIn 0.3s ease;
        }
    </style>
</nav>

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
                        <i class="fas fa-store me-2" style="font-size: 1.2rem;"></i>Shop
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-custom {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        <i class="fas fa-envelope me-2" style="font-size: 1.2rem;"></i>Contact
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
                                <i class="fas fa-search" style="font-size: 1.1rem;"></i>
                            </button>
                        </div>
                    </form>
                </li>

                @auth
                    <!-- Hidden Admin Dashboard Access (Only for Admins) -->
                    @if (auth()->user()->is_admin ?? false)
                        <li class="nav-item">
                            <a class="nav-link admin-dashboard-link" href="{{ route('admin.dashboard') }}"
                                title="Admin Dashboard" data-bs-toggle="tooltip" data-bs-placement="bottom">
                                <i class="fas fa-cogs" style="font-size: 1.5rem; color: #1976d2;"></i>
                            </a>
                        </li>
                    @endif
                @endauth
                @guest
                    <!-- Guest User Menu -->
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('login') }}">
                            <i class="fas fa-sign-in-alt me-2" style="font-size: 1.2rem;"></i>Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link nav-link-custom" href="{{ route('register') }}">
                            <i class="fas fa-user-plus me-2" style="font-size: 1.2rem;"></i>Register
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
                        <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="user-avatar me-2">
                                @if ($avatarUrl)
                                    <img src="{{ $avatarUrlWithVersion ?? $avatarUrl }}" alt="User"
                                        class="rounded-circle" style="width: 32px; height: 32px; object-fit: cover;" />
                                @else
                                    <div class="default-avatar d-flex align-items-center justify-content-center rounded-circle"
                                        style="width: 32px; height: 32px; background: linear-gradient(45deg, #28a745, #20c997); color: white;">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <span>{{ $u->name ?? 'User' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
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
                            <i class="fas fa-shopping-cart" style="font-size: 1.3rem;"></i>
                            <span class="cart-badge">0</span>
                        </div>
                        <span class="ms-2">Cart</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <style>
        /* Modern Beautiful Navbar Styles */
        .navbar {
            background: #e3f2fd !important;
            padding: 1rem 0;
            transition: all 0.3s ease;
            box-shadow: 0 2px 20px rgba(33, 150, 243, 0.1);
            border-bottom: 1px solid rgba(33, 150, 243, 0.1);
        }

        .navbar-brand .brand-name {
            color: #2196f3 !important;
            font-weight: 700;
            text-shadow: none;
        }

        .navbar-brand .brand-logo i {
            color: #2196f3 !important;
            font-size: 1.8rem;
        }

        .nav-link-custom {
            color: #2196f3 !important;
            padding: 0.75rem 1.25rem !important;
            border-radius: 12px;
            margin: 0 0.25rem;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 1.05rem;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            background-color: rgba(33, 150, 243, 0.1);
            color: #1976d2 !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.2);
        }

        /* Dropdown Styles */
        .nav-link.dropdown-toggle {
            color: #2196f3 !important;
        }

        .nav-link.dropdown-toggle:hover {
            color: #1976d2 !important;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 8px 30px rgba(33, 150, 243, 0.15);
            border-radius: 15px;
            padding: 0.5rem 0;
            margin-top: 0.5rem;
        }

        .dropdown-item {
            color: #2196f3 !important;
            padding: 0.75rem 1.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .dropdown-item:hover {
            background-color: rgba(33, 150, 243, 0.1);
            color: #1976d2 !important;
            transform: translateX(5px);
        }

        .dropdown-item.text-danger {
            color: #dc3545 !important;
        }

        .dropdown-item.text-danger:hover {
            background-color: rgba(220, 53, 69, 0.1);
            color: #c82333 !important;
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
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(33, 150, 243, 0.2);
            border-radius: 25px;
            padding: 0.75rem 3rem 0.75rem 1.5rem;
            color: #2196f3;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .search-input::placeholder {
            color: rgba(33, 150, 243, 0.6);
        }

        .search-input:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #2196f3;
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
            outline: none;
        }

        .search-btn {
            position: absolute;
            right: 8px;
            background: linear-gradient(45deg, #2196f3, #1976d2);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }

        .search-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4);
        }

        /* Cart Styles */
        .cart-link {
            position: relative;
            display: flex;
            align-items: center;
            color: #2196f3 !important;
        }

        .cart-link:hover {
            color: #1976d2 !important;
        }

        .cart-wrapper {
            position: relative;
            display: inline-block;
        }

        .cart-wrapper i {
            font-size: 1.3rem;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: linear-gradient(45deg, #2196f3, #1976d2);
            color: white;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(33, 150, 243, 0.3);
        }

        /* Enhanced Icon Sizes */
        .nav-link-custom i {
            font-size: 1.2rem;
            margin-right: 0.5rem;
        }

        .dropdown-item i {
            font-size: 1.1rem;
            margin-right: 0.5rem;
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
                font-size: 1.1rem;
            }

            .nav-link-custom i {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 576px) {
            .search-input {
                width: 150px;
            }

            .brand-name {
                font-size: 1.3rem !important;
            }

            .brand-logo i {
                font-size: 2rem !important;
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

            .search-btn i {
                font-size: 1rem;
            }

            /* Admin Dashboard Link - Hidden but Accessible */
            .admin-dashboard-link {
                color: #ffc107 !important;
                /* Golden color to make it subtle but noticeable */
                padding: 0.5rem !important;
                margin: 0 0.25rem;
                border-radius: 50%;
                transition: all 0.3s ease;
                opacity: 0.7;
                /* Make it slightly transparent */
                position: relative;
            }

            .admin-dashboard-link:hover {
                color: #ff8f00 !important;
                opacity: 1;
                /* Full opacity on hover */
                transform: scale(1.1) rotate(15deg);
                background-color: rgba(255, 193, 7, 0.1);
                box-shadow: 0 0 10px rgba(255, 193, 7, 0.3);
            }

            .admin-dashboard-link i {
                font-size: 1rem;
                transition: all 0.3s ease;
            }

            /* Tooltip styling */
            .admin-dashboard-link[data-bs-toggle="tooltip"] {
                cursor: help;
            }

            /* Pulse animation to subtly draw attention */
            @keyframes adminPulse {
                0% {
                    box-shadow: 0 0 0 0 rgba(255, 193, 7, 0.4);
                }

                50% {
                    box-shadow: 0 0 0 8px rgba(255, 193, 7, 0);
                }

                100% {
                    box-shadow: 0 0 0 0 rgba(255, 193, 7, 0);
                }
            }

            .admin-dashboard-link {
                animation: adminPulse 3s infinite;
            }
        }

        /* Beautiful hover effects */
        .navbar-brand:hover .brand-logo i {
            transform: scale(1.1);
            transition: transform 0.3s ease;

            <script>
                // Initialize Bootstrap tooltips
                document.addEventListener('DOMContentLoaded', function() {
                            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
                            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {

                                        <
                                        script >
                                            // Initialize Bootstrap tooltips
                                            document.addEventListener('DOMContentLoaded', function() {
                                                var tooltipTriggerList = [].slice.call(document.querySelectorAll(
                                                    '[data-bs-toggle="tooltip"]'));
                                                var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                                                    return new bootstrap.Tooltip(tooltipTriggerEl);
                                                });
                                            });

                                        // Konami Code Easter Egg for Admin Access
                                        (function() {
                                                var konamiCode = [
                                                    'ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown',
                                                    'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight',
                                                    'KeyB', 'KeyA'
                                                ];
                                                var userInput = [];
                                                var konamiTriggered = false;

                                                document.addEventListener('keydown', function(e) {
                                                        userInput.push(e.code);

                                                        if (userInput.length > konamiCode.length) {
                                                            userInput.shift();
                                                        }

                                                        if (userInput.join(',') === konamiCode.join(',') && !konamiTriggered) {
                                                            konamiTriggered = true;

                                                            // Check if user is authenticated and is admin
                                                            @auth
                                                            @if (auth()->check() && auth()->user()->is_admin)
                                                                // Show admin access notification
                                                                var notification = document.createElement('div');
                                                                notification.className = 'alert alert-success position-fixed';
                                                                notification.style.cssText =
                                                                    'top: 20px; right: 20px; z-index: 9999; animation: slideIn 0.5s ease;';
                                                                notification.innerHTML = `
                                <i class="fas fa-keyboard me-2"></i>
                                <strong>Admin Mode Activated!</strong>
                                <a href="{{ route('admin.dashboard') }}" class="alert-link">Go to Dashboard</a>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;
                                                                document.body.appendChild(notification);

                                                                // Auto-remove after 5 seconds
                                                                setTimeout(function() {
                                                                    if (notification.parentNode) {
                                                                        notification.remove();
                                                                    }
                                                                }, 5000);
                                                            @else
                                                                // Show message for non-admin users
                                                                var notification = document.createElement('div');
                                                                notification.className = 'alert alert-warning position-fixed';
                                                                notification.style.cssText =
                                                                    'top: 20px; right: 20px; z-index: 9999; animation: slideIn 0.5s ease;';
                                                                notification.innerHTML = `
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Access Denied!</strong> Admin privileges required.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            `;
                                                                document.body.appendChild(notification);

                                                                setTimeout(function() {
                                                                    if (notification.parentNode) {
                                                                        notification.remove();
                                                                    }
                                                                }, 3000);
                                                            @endif
                                                        @endauth

                                                        // Reset after showing
                                                        setTimeout(function() {
                                                            konamiTriggered = false;
                                                        }, 3000);
                                                    }
                                                });

                                            // Add CSS for slide-in animation
                                            var style = document.createElement('style'); style.textContent = `
                @keyframes slideIn {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `; document.head.appendChild(style);
                                        })();
            </script>return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        });
        </script>
        }

        .search-btn i {
            font-size: 1rem;
        }
    </style>
</nav>

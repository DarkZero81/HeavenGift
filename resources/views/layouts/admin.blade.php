<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>لوحة التحكم - Gift Haven</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Custom styles -->
    <style>
        :root {
            --primary: #667eea;
            /* Orange */
            --secondary: #764ba2;
            /* Purple */
            --dark: #0F061E;
            /* Very Dark Blue/Black */
            --light: #F8F9FA;
            /* Off-White */
            --accent: #FFD200;
            /* Yellow Accent */
        }

        body {
            /* Full screen gradient background matching the GiftHaven.html file */
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 50%, var(--dark) 100%);
            color: var(--light);
            min-height: 100vh;
            font-family: 'Inter', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .sidebar {
            background-color: var(--primary);
            min-height: 100vh;
            color: white;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, .8);
            padding: 0.75rem 1rem;
        }

        .sidebar .nav-link:hover {
            color: white;
            background-color: rgba(255, 255, 255, .1);
        }

        .sidebar .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, .2);
        }

        .navbar {
            background-color: white;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }

        .badge-success {
            background-color: var(--success);
        }

        .badge-warning {
            background-color: var(--warning);
        }

        .badge-danger {
            background-color: var(--danger);
        }

        .badge-info {
            background-color: var(--info);
        }

        .badge-primary {
            background-color: var(--primary);
        }

        .badge-secondary {
            background-color: var(--secondary);

            .badge-secondary {
                background-color: var(--secondary);
            }

            /* Enhanced Sidebar Styling */
            .sidebar .nav-section-title {
                color: var(--accent);
                font-size: 0.9rem;
                font-weight: 600;
                text-transform: uppercase;
                letter-spacing: 1px;
                margin: 1.5rem 0 0.5rem 1rem;
                opacity: 0.8;
            }

            .sidebar .nav-item {
                margin-bottom: 0.25rem;
            }

            .sidebar .nav-link {
                border-radius: 8px;
                margin: 0 0.5rem;
                transition: all 0.3s ease;
                position: relative;
                overflow: hidden;
            }

            .sidebar .nav-link::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
                transition: left 0.5s;
            }

            .sidebar .nav-link:hover::before {
                left: 100%;
            }

            .sidebar .nav-link i {
                width: 20px;
                text-align: center;

                /* Card border styles for analytics dashboard */
                .border-left-primary {
                    border-left: 4px solid var(--primary) !important;
                }

                .border-left-success {
                    border-left: 4px solid #28a745 !important;
                }

                .border-left-info {
                    border-left: 4px solid #17a2b8 !important;
                }

                .border-left-warning {
                    border-left: 4px solid #ffc107 !important;
                }

                /* Chart area styling */
                .chart-area {
                    position: relative;
                    height: 350px;
                    width: 100%;
                }
            }
        }
    </style>
</head>

<body class="p-0">
    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block sidebar collapse rounded-3 fs-4">
                </li>
                </ul>


                <div class="position-sticky pt-3">
                    <div class="text-center mb-4">
                        <h4><i class="bi bi-gift me-2"></i>Gift Haven</h4>
                    </div>

                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin') ? 'active' : '' }}"
                                href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2 me-2"></i>
                                DashBoard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/products*') ? 'active' : '' }}"
                                href="{{ route('admin.products.index') }}">
                                <i class="bi bi-gift me-2"></i>
                                Products
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/categories*') ? 'active' : '' }}"
                                href="{{ route('admin.categories.index') }}">
                                <i class="bi bi-tags me-2"></i>
                                Category
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/orders*') ? 'active' : '' }}"
                                href="{{ route('admin.orders.index') }}">
                                <i class="bi bi-cart me-2"></i>
                                Orders
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/coupons*') ? 'active' : '' }}"
                                href="{{ route('admin.coupons.index') }}">
                                <i class="bi bi-ticket-perforated me-2"></i>
                                Coupons
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/reviews*') ? 'active' : '' }}"
                                href="{{ route('admin.reviews.index') }}">
                                <i class="bi bi-star me-2"></i>
                                Reviews
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/payments*') ? 'active' : '' }}"
                                href="{{ route('admin.payments.index') }}">
                                <i class="bi bi-credit-card me-2"></i>
                                Payments
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/users*') ? 'active' : '' }}"
                                href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people me-2"></i>
                                Users
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/analytics*') ? 'active' : '' }}"
                                href="{{ route('admin.analytics') }}">
                                <i class="bi bi-graph-up me-2"></i>
                                Analytics
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Request::is('admin/settings*') ? 'active' : '' }}"
                                href="{{ route('admin.settings') }}">
                                <i class="bi bi-gear me-2"></i>
                                Settings
                            </a>
                        </li>
                    </ul>

                    <hr>

                    <ul class="nav flex-column mb-2">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/') }}" target="_blank">
                                <i class="bi bi-shop me-2"></i>
                                Visit Shop
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/userinfo') }}" target="_blank">
                                <i class="bi bi-person me-2"></i>
                                Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="nav-link btn btn-link text-start w-100 fs-4">
                                    <i class="bi bi-box-arrow-right me-2"></i>
                                    Log-out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 p-0">
                <!-- Navbar -->
                <nav class="navbar navbar-expand-lg navbar-light bg-white mb-4">
                    <div class="container-fluid">
                        <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="navbarSupportedContent">
                            @include('partials.navbar')

                        </div>
                    </div>
                </nav>

                <!-- Page content -->
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Bootstrap & jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    @yield('scripts')
</body>

</html>

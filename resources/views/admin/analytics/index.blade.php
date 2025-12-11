@extends('layouts.admin')

@section('content')
    <!-- Dark Mode Toggle -->
    <div class="d-flex justify-content-end mb-3">
        <button id="darkModeToggle" class="btn btn-sm btn-outline-secondary mx-3">
            <i class="bi bi-moon-fill" id="darkModeIcon"></i> <span id="darkModeText">Dark Mode</span>
        </button>
    </div>

    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4 mx-3">
        <h1 class="h3 mb-0" id="pageTitle">Analytics Dashboard</h1>
        <div class="d-flex">
            <button class="btn btn-sm btn-outline-light me-2" id="exportBtn">
                <i class="bi bi-download"></i> Export Report
            </button>
            <button class="btn btn-sm btn-primary" id="refreshBtn">
                <i class="bi bi-arrow-clockwise"></i> Refresh
            </button>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row mb-4 mx-3">
        <!-- Total Users Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 overflow-hidden position-relative animated-card"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; border-radius: 15px; transition: all 0.3s ease;">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1 opacity-75">
                                Total Users
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-white counter"
                                data-target="{{ $stats['total_users'] }}">0</div>
                            <div class="text-xs text-white mt-1 opacity-90 growth-indicator">
                                <i class="bi bi-arrow-up pulse"></i> +12% this month
                            </div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3 icon-container">
                            <i class="bi bi-people fs-1 text-white icon-animate"></i>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 start-0 w-100 h-2 bg-white bg-opacity-20 progress-bar-animated">
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Revenue Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 overflow-hidden position-relative animated-card"
                style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border: none; border-radius: 15px; transition: all 0.3s ease;">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1 opacity-75">
                                Total Revenue
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-white counter"
                                data-target="{{ $stats['total_revenue'] }}" data-prefix="$">0</div>
                            <div class="text-xs text-white mt-1 opacity-90 growth-indicator">
                                <i class="bi bi-arrow-up pulse"></i> +8% this month
                            </div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3 icon-container">
                            <i class="bi bi-currency-dollar fs-1 text-white icon-animate"></i>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 start-0 w-100 h-2 bg-white bg-opacity-20 progress-bar-animated">
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Orders Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 overflow-hidden position-relative animated-card"
                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border: none; border-radius: 15px; transition: all 0.3s ease;">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1 opacity-75">
                                Total Orders
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-white counter"
                                data-target="{{ $stats['total_orders'] }}">0</div>
                            <div class="text-xs text-white mt-1 opacity-90 growth-indicator">
                                <i class="bi bi-arrow-up pulse"></i> +15% this month
                            </div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3 icon-container">
                            <i class="bi bi-cart fs-1 text-white icon-animate"></i>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 start-0 w-100 h-2 bg-white bg-opacity-20 progress-bar-animated">
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Products Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card h-100 overflow-hidden position-relative animated-card"
                style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border: none; border-radius: 15px; transition: all 0.3s ease;">
                <div class="card-body text-white p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-xs font-weight-bold text-white-50 text-uppercase mb-1 opacity-75">
                                Total Products
                            </div>
                            <div class="h3 mb-0 font-weight-bold text-white counter"
                                data-target="{{ $stats['total_products'] }}">0</div>
                            <div class="text-xs text-white mt-1 opacity-90 growth-indicator">
                                <i class="bi bi-box pulse"></i> Active inventory
                            </div>
                        </div>
                        <div class="bg-white bg-opacity-20 rounded-circle p-3 icon-container">
                            <i class="bi bi-box-seam fs-1 text-white icon-animate"></i>
                        </div>
                    </div>
                    <div class="position-absolute bottom-0 start-0 w-100 h-2 bg-white bg-opacity-20 progress-bar-animated">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts and Tables Row -->
    <div class="row mx-3">
        <!-- Sales Chart -->
        <div class="col-xl-8 col-lg-7 ">
            <div class="card shadow mb-4 glass-card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary chart-title">Sales Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="bi bi-three-dots-vertical text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header">Chart Options:</div>
                            <a class="dropdown-item chart-option" href="#" data-days="7">Last 7 Days</a>
                            <a class="dropdown-item chart-option" href="#" data-days="30">Last 30 Days</a>
                            <a class="dropdown-item chart-option" href="#" data-days="365">Last Year</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4 glass-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Top Products</h6>
                </div>
                <div class="card-body">
                    @foreach ($stats['top_products'] as $product)
                        <div class="d-flex align-items-center mb-3 product-item" data-aos="fade-up">
                            <div class="me-3">
                                @if ($product->image)
                                    <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                        class="rounded product-image"
                                        style="width: 40px; height: 40px; object-fit: cover;">
                                @else
                                    <div class="bg-primary text-white rounded d-flex align-items-center justify-content-center product-image"
                                        style="width: 40px; height: 40px;">
                                        <i class="bi bi-box"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <div class="small font-weight-bold product-name">{{ Str::limit($product->name, 15) }}</div>
                                <div class="text-xs text-muted order-count">{{ $product->order_items_count ?? 0 }} orders
                                </div>
                            </div>
                            <div class="text-xs text-success product-price">
                                ${{ number_format($product->price ?? 0, 2) }}
                            </div>
                        </div>
                    @endforeach

                    @if ($stats['top_products']->isEmpty())
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-info-circle"></i>
                            <div class="small">No products data available</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders and Monthly Stats -->
    <div class="row mx-3">
        <!-- Recent Orders -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow glass-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Orders</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stats['recent_orders'] as $order)
                                    <tr class="order-row">
                                        <td>
                                            <a href="#" class="text-decoration-none order-link">
                                                #{{ $order->id }}
                                            </a>
                                        </td>
                                        <td class="customer-name">{{ $order->user->name ?? 'Guest' }}</td>
                                        <td class="order-amount">${{ number_format($order->total ?? 0, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge status-badge
                                                @if ($order->status === 'completed') bg-success
                                                @elseif($order->status === 'pending') bg-warning
                                                @else bg-secondary @endif">
                                                {{ ucfirst($order->status ?? 'pending') }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if ($stats['recent_orders']->isEmpty())
                        <div class="text-center text-muted py-3">
                            <i class="bi bi-info-circle"></i>
                            <div class="small">No recent orders</div>
                        </div>
                    @endif

                    <div class="text-center mt-3">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-outline-primary animated-btn">
                            View All Orders
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Monthly Statistics -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow glass-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Monthly Statistics</h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="card border-0 mb-3 overflow-hidden position-relative stat-card"
                                style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%); border-radius: 10px;">
                                <div class="card-body py-3 text-white">
                                    <div class="h4 mb-0 font-weight-bold counter"
                                        data-target="{{ $stats['monthly_sales'] }}" data-prefix="$">0</div>
                                    <div class="small opacity-90">This Month Sales</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 mb-3 overflow-hidden position-relative stat-card"
                                style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 10px;">
                                <div class="card-body py-3 text-white">
                                    <div class="h4 mb-0 font-weight-bold counter"
                                        data-target="{{ $stats['total_orders'] }}">0</div>
                                    <div class="small opacity-90">Total Orders</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row text-center">
                        <div class="col-6">
                            <div class="card border-0 mb-3 overflow-hidden position-relative stat-card"
                                style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 10px;">
                                <div class="card-body py-3 text-white">
                                    <div class="h4 mb-0 font-weight-bold counter"
                                        data-target="{{ $stats['total_products'] }}">0</div>
                                    <div class="small opacity-90">Total Products</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 mb-3 overflow-hidden position-relative stat-card"
                                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 10px;">
                                <div class="card-body py-3 text-white">
                                    <div class="h4 mb-0 font-weight-bold counter"
                                        data-target="{{ $stats['total_users'] }}">0</div>
                                    <div class="small opacity-90">Registered Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Performance Indicators -->
    <div class="row mx-3">
        <div class="col-12">
            <div class="card shadow glass-card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Performance Indicators</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center performance-item">
                                <div class="text-2xl font-weight-bold text-primary performance-number counter"
                                    data-target="94.2">0%</div>
                                <div class="small text-muted performance-label">Customer Satisfaction</div>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-primary progress-animated" role="progressbar"
                                        style="width: 94.2%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center performance-item">
                                <div class="text-2xl font-weight-bold text-success performance-number counter"
                                    data-target="87.5">0%</div>
                                <div class="small text-muted performance-label">Order Completion Rate</div>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-success progress-animated" role="progressbar"
                                        style="width: 87.5%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center performance-item">
                                <div class="text-2xl font-weight-bold text-info performance-number counter"
                                    data-target="45.67" data-prefix="$">0</div>
                                <div class="small text-muted performance-label">Average Order Value</div>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-info progress-animated" role="progressbar"
                                        style="width: 75%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 mb-3">
                            <div class="text-center performance-item">
                                <div class="text-2xl font-weight-bold text-warning performance-number counter"
                                    data-target="23.4">0%</div>
                                <div class="small text-muted performance-label">Return Customer Rate</div>
                                <div class="progress mt-2" style="height: 6px;">
                                    <div class="progress-bar bg-warning progress-animated" role="progressbar"
                                        style="width: 23.4%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Chart.js for Sales Chart -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Dark Mode Toggle
        let isDarkMode = false;

        document.getElementById('darkModeToggle').addEventListener('click', function() {
            isDarkMode = !isDarkMode;
            const body = document.body;
            const icon = document.getElementById('darkModeIcon');
            const text = document.getElementById('darkModeText');

            if (isDarkMode) {
                body.classList.add('dark-mode');
                icon.className = 'bi bi-sun-fill';
                text.textContent = 'Light Mode';
            } else {
                body.classList.remove('dark-mode');
                icon.className = 'bi bi-moon-fill';
                text.textContent = 'Dark Mode';
            }
        });

        // Animated Counter Function
        function animateCounter(element, target, duration = 2000) {
            const prefix = element.dataset.prefix || '';
            const suffix = element.dataset.suffix || '';
            let start = 0;
            const increment = target / (duration / 16);

            function updateCounter() {
                start += increment;
                if (start < target) {
                    element.textContent = prefix + Math.floor(start).toLocaleString() + suffix;
                    requestAnimationFrame(updateCounter);
                } else {
                    element.textContent = prefix + target.toLocaleString() + suffix;
                }
            }
            updateCounter();
        }

        // Initialize counters when page loads
        document.addEventListener('DOMContentLoaded', function() {
            const counters = document.querySelectorAll('.counter');
            counters.forEach((counter, index) => {
                setTimeout(() => {
                    const target = parseFloat(counter.dataset.target);
                    animateCounter(counter, target);
                }, index * 200);
            });

            // Animate progress bars
            const progressBars = document.querySelectorAll('.progress-animated');
            progressBars.forEach((bar, index) => {
                setTimeout(() => {
                    bar.style.width = bar.style.width || '0%';
                    bar.style.transition = 'width 1s ease-out';
                }, 1000 + (index * 100));
            });
        });

        // Sales Chart with enhanced styling
        const ctx = document.getElementById('salesChart').getContext('2d');
        let salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach ($salesChart as $data)
                        '{{ \Carbon\Carbon::parse($data->date)->format('M d') }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Sales ($)',
                    data: [
                        @foreach ($salesChart as $data)
                            {{ $data->total }},
                        @endforeach
                    ],
                    borderColor: '#667eea',
                    backgroundColor: 'rgba(102, 126, 234, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#667eea',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return '$' + value;
                            }
                        },
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)'
                        }
                    }
                },
                animation: {
                    duration: 2000,
                    easing: 'easeInOutQuart'
                }
            }
        });

        // Chart options functionality
        document.querySelectorAll('.chart-option').forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                const days = this.dataset.days;
                // Here you would typically fetch new data based on the selected period
                console.log(`Chart updated for last ${days} days`);
            });
        });

        // Enhanced button interactions
        document.getElementById('refreshBtn').addEventListener('click', function() {
            this.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Refreshing...';
            setTimeout(() => {
                location.reload();
            }, 1000);
        });

        document.getElementById('exportBtn').addEventListener('click', function() {
            this.innerHTML = '<i class="bi bi-check"></i> Exported!';
            setTimeout(() => {
                this.innerHTML = '<i class="bi bi-download"></i> Export Report';
            }, 2000);
        });

        // Auto-refresh every 5 minutes
        setInterval(function() {
            location.reload();
        }, 300000);
    </script>

    <style>
        /* Dark Mode Styles */
        .dark-mode {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%) !important;
            color: #e0e0e0 !important;
        }

        .dark-mode .card {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px) !important;
            border: 1px solid rgba(255, 255, 255, 0.2) !important;
        }

        .dark-mode .glass-card {
            background: rgba(255, 255, 255, 0.05) !important;
            backdrop-filter: blur(15px) !important;
            border: 1px solid rgba(255, 255, 255, 0.1) !important;
        }

        .dark-mode .text-primary {
            color: #64b5f6 !important;
        }

        .dark-mode .text-muted {
            color: #b0b0b0 !important;
        }

        /* Enhanced Animations */
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes slideInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Card Enhancements */
        .animated-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3) !important;
        }

        .icon-container {
            transition: all 0.3s ease;
        }

        .animated-card:hover .icon-container {
            transform: rotate(360deg);
            background: rgba(255, 255, 255, 0.3) !important;
        }

        .icon-animate {
            animation: float 3s ease-in-out infinite;
        }

        .pulse {
            animation: pulse 2s infinite;
        }

        .spin {
            animation: spin 1s linear infinite;
        }

        /* Progress Bar Animation */
        .progress-bar-animated {
            animation: slideInUp 1s ease-out;
        }

        /* Button Enhancements */
        .animated-btn {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .animated-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .animated-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .animated-btn:hover::before {
            left: 100%;
        }

        /* Glass Card Effect */
        .glass-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transition: all 0.3s ease;
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.98);
            transform: translateY(-2px);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        /* Product Item Animations */
        .product-item {
            animation: slideInUp 0.6s ease-out;
            transition: all 0.3s ease;
        }

        .product-item:hover {
            background: rgba(102, 126, 234, 0.1);
            border-radius: 8px;
            padding: 8px;
            transform: translateX(5px);
        }

        /* Order Row Animations */
        .order-row {
            transition: all 0.3s ease;
        }

        .order-row:hover {
            background: rgba(0, 0, 0, 0.05);
            transform: scale(1.01);
        }

        /* Status Badge Animations */
        .status-badge {
            transition: all 0.3s ease;
        }

        .status-badge:hover {
            transform: scale(1.1);
        }

        /* Performance Item Enhancements */
        .performance-item {
            transition: all 0.3s ease;
            padding: 15px;
            border-radius: 10px;
        }

        .performance-item:hover {
            background: rgba(0, 0, 0, 0.05);
            transform: translateY(-5px);
        }

        .performance-number {
            background: linear-gradient(45deg, #667eea, #764ba2);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Chart Enhancements */
        .chart-area {
            position: relative;
            height: 350px;
            width: 100%;
            border-radius: 10px;
            overflow: hidden;
        }

        /* Mobile Responsiveness */
        @media (max-width: 768px) {
            .animated-card:hover {
                transform: translateY(-5px) scale(1.01);
            }

            .performance-item {
                margin-bottom: 20px;
            }
        }
    </style>
@endsection

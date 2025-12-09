@extends('layouts.admin')

@section('content')
    <style>
        /* CSS adapted for the smallest, simplest rectangular form */
        .stat-card {
            background: purple;
            border-radius: 12px;
            box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.1);
            padding: 0.75rem 1rem;
            /* Reduced padding greatly */
            color: #f3f6fa;
            display: flex;
            align-items: center;
            /* Align items vertically in the center */
            height: 100%;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card-content {
            flex-grow: 1;
            /* Allows content area to fill space */
            padding-right: 10px;
        }

        .stat-card-header h2 {
            font-family: "Inter", sans-serif;
            font-size: 1.7rem;
            /* Very reduced size for main number */
            font-weight: 700;
            color: #fff;
            margin: 0;
            line-height: 1;
            /* Simple text shadow for visibility */
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .stat-card-title {
            font-family: "Inter", sans-serif;
            font-size: 0.9rem;
            /* Smallest size for title */
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            line-height: 1.2;
            opacity: 0.9;
        }

        .stat-card-icon-area {
            /* Icon area is now fixed size on the right */
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .stat-card-icon {
            width: 50px;
            /* Icon is now very small */
            height: 50px;
            /* Icon is now very small */
            color: rgba(255, 255, 255, 0.85);
            /* Slightly transparent icon */
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.1));
            opacity: 0.9;
        }

        .stat-card-footer {
            /* Footer/More Info link is removed entirely for a cleaner look */
            display: none;
        }

        /* Override specific text/icon colors for the white card for contrast */
        .stat-card.white-card {
            color: #212121 !important;
        }

        .stat-card.white-card .stat-card-header h2,
        .stat-card.white-card .stat-card-title,
        .stat-card.white-card .stat-card-icon {
            color: #212121 !important;
            opacity: 1 !important;
        }
    </style>
    <div class="p-4">
        <div class="container-fluid">
            <h1 class="h3 mb-4">Dashboard</h1>
            <div class="row g-3">

                {{-- Row 1: Total Orders (Blue) --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="stat-card" style="background: #1e88e5;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>{{ $stats['total_orders'] }}</h2>
                            </div>
                            <p class="stat-card-title">Total Orders</p>
                        </div>
                        <div class="stat-card-icon-area">
                            {{-- Shopping Cart Icon --}}
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path
                                    d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Row 1: Unique Visitors (Red) --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="stat-card" style="background: #e53935;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>65</h2>
                            </div>
                            <p class="stat-card-title">Unique Visitors</p>
                        </div>
                        <div class="stat-card-icon-area">
                            {{-- Chart Pie Icon --}}
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                                </path>
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Row 1: Bounce Rate (Green) --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="stat-card" style="background: #43A047;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>53<sup class="fs-6">%</sup></h2>
                            </div>
                            <p class="stat-card-title">Bounce Rate</p>
                        </div>
                        <div class="stat-card-icon-area">
                            {{-- Bar Chart Icon --}}
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path
                                    d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Row 1: User Registrations (Yellow/Gold) --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="stat-card" style="background: #F9A825;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>44</h2>
                            </div>
                            <p class="stat-card-title">User Registrations</p>
                        </div>
                        <div class="stat-card-icon-area">
                            {{-- User Plus Icon --}}
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path
                                    d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-3 g-3">
                {{-- Row 2: Total Products (Cyan/Light Blue) --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="stat-card" style="background: #00BCD4;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>{{ $stats['total_products'] }}</h2>
                            </div>
                            <p class="stat-card-title">Total Products</p>
                        </div>
                        <div class="stat-card-icon-area">
                            {{-- Boxes Icon --}}
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path clip-rule="evenodd" fill-rule="evenodd"
                                    d="M3 2.25a.75.75 0 01.75.75v.516l14.85 3.328a.75.75 0 01.536.842l-1.35 4.864a.75.75 0 01-.842.536L3.75 4.316V18.75a.75.75 0 001.5 0V5.992l12.75 2.85V18.75a.75.75 0 001.5 0V7.5a.75.75 0 00-.088-.387L5.006 3.006a.75.75 0 00-.638-.114L3.75 2.516V3A.75.75 0 013 3z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Row 2: Total Categories (Grey) --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="stat-card" style="background: #607D8B;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>{{ $stats['total_categories'] }}</h2>
                            </div>
                            <p class="stat-card-title">Total Categories</p>
                        </div>
                        <div class="stat-card-icon-area">
                            {{-- Tags Icon --}}
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path
                                    d="M5.625 1.5H9.75a.75.75 0 01.75.75v10.5a.75.75 0 01-1.5 0V7.31c-.35-.134-.727-.247-1.127-.34a10.05 10.05 0 00-3.136-.395l-.75-.025A.75.75 0 013 6.475v-4.5A.75.75 0 013.75 1.5h1.875zM12.75 3a.75.75 0 01.75-.75h3.375c.621 0 1.125.504 1.125 1.125v7.5a.75.75 0 01-1.5 0V4.5H13.5v15h-.75V19.5a.75.75 0 01-1.5 0V7.5h-1.5V6h1.5V4.5a1.5 1.5 0 011.5-1.5z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Row 2: Total Users (Black) --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="stat-card" style="background: #212121;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>{{ $stats['total_users'] }}</h2>
                            </div>
                            <p class="stat-card-title">Total Users</p>
                        </div>
                        <div class="stat-card-icon-area">
                            {{-- Users Icon --}}
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path
                                    d="M11.5 13.5a6 6 0 10-6 6h12a6 6 0 10-6-6zM12 2.25a.75.75 0 01.75.75v.75a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM4.5 9a.75.75 0 01.75-.75h.75a.75.75 0 010 1.5h-.75A.75.75 0 014.5 9zM18 9a.75.75 0 01.75-.75h.75a.75.75 0 010 1.5h-.75A.75.75 0 0118 9zM6.5 13.5a.75.75 0 00-.75.75v.75a.75.75 0 001.5 0v-.75a.75.75 0 00-.75-.75zM16.5 13.5a.75.75 0 00-.75.75v.75a.75.75 0 001.5 0v-.75a.75.75 0 00-.75-.75z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                {{-- Row 2: Total Visitors (White/Light) --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="stat-card white-card" style="background: #E0E0E0;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>4</h2>
                            </div>
                            <p class="stat-card-title">Total Visitors</p>
                        </div>
                        <div class="stat-card-icon-area">
                            {{-- Eye Icon (Dark color provided via inline style) --}}
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path
                                    d="M12 4.5c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8zM12 18.5c-3.59 0-6.5-2.91-6.5-6.5s2.91-6.5 6.5-6.5 6.5 2.91 6.5 6.5-2.91 6.5-6.5 6.5zM12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM12 15c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="my-4 border-light opacity-50">
            @include('partials.charts')
            <div class="card shadow mb-4 ">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Last Orders</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Order Number</th>
                                    <th>Client</th>
                                    <th>Total</th>
                                    <th>State</th>
                                    <th>Date</th>
                                    <th>Procedures</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($stats['recent_orders'] as $order)
                                    <tr>
                                        <td>#{{ $order->id }}</td>
                                        <td>{{ $order->customer_name }}</td>
                                        <td>${{ number_format($order->total, 2) }}</td>
                                        <td>
                                            <span
                                                class="badge text-{{ $order->status == 'pending' ? 'warning' : ($order->status == 'processing' ? 'info' : 'success') }}">
                                                {{ $order->status }}
                                            </span>
                                        </td>
                                        <td>{{ $order->created_at->format('Y-m-d') }}</td>
                                        <td>
                                            <a href="{{ route('admin.orders.show', $order->id) }}"
                                                class="btn btn-sm btn-primary">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

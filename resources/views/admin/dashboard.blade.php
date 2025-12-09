@extends('layouts.admin')

@section('content')
    <style>
        /* From Uiverse.io by code-town3 */
        .stat-card {
            background: purple;
            border-radius: 18px;
            box-shadow: 0 4px 24px 0 rgba(0, 0, 0, 0.18);
            padding: 2rem 1.5rem 1.5rem 1.5rem;
            width: 340px;
            color: #f3f6fa;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .stat-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-card-header h2 {
            font-family: "Inter", sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: #f3f6fa;
            letter-spacing: 0.01em;
            margin: 0;
            line-height: 1.2;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background: linear-gradient(90deg, #fff 0%, #f3f6fa 50%, #e3e8ef 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-card-title {
            font-family: "Inter", sans-serif;
            font-size: 1.35rem;
            font-weight: 700;
            color: #f3f6fa;
            letter-spacing: 0.01em;
            margin: 0;
            line-height: 1.2;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            background: linear-gradient(90deg, #fff 0%, #f3f6fa 50%, #e3e8ef 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-card-menu {
            font-size: 1.3rem;
            color: #6c7383;
            cursor: pointer;
        }

        .stat-card-chart {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .donut {
            width: 170px;
            height: 170px;
        }

        .donut-bg {
            fill: none;
            stroke: #232733;
            stroke-width: 14;
        }

        .donut-segment.sales {
            stroke: #3d8bff;
        }

        .donut-segment.product {
            stroke: #ff6a3d;
        }

        .donut-segment.income {
            stroke: #1ecb6b;
        }

        .donut-segment {
            fill: none;
            stroke-width: 14;
            stroke-linecap: round;
            transition: stroke-dasharray 0.3s;
        }

        .donut-segment2 {
            fill: none;
            stroke: #1ecb6b;
            stroke-width: 14;
            stroke-linecap: round;
            transition: stroke-dasharray 0.3s;
        }

        .donut-segment3 {
            fill: none;
            stroke: #3d8bff;
            stroke-width: 14;
            stroke-linecap: round;
            transition: stroke-dasharray 0.3s;
        }

        .donut-text-main {
            font-size: 2.1rem;
            font-weight: 600;
            fill: #f3f6fa;
        }

        .donut-text-sub {
            font-size: 1rem;
            fill: #b0b6c3;
        }

        .stat-card-legend {
            margin-top: 0.5rem;
            display: flex;
            flex-direction: column;
            gap: 0.6rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 1rem;
            color: #b0b6c3;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 0.5rem;
        }

        .legend-dot.sales {
            background: #3d8bff;
        }

        .legend-dot.product {
            background: #ff6a3d;
        }

        .legend-dot.income {
            background: #1ecb6b;
        }

        .legend-value {
            font-size: 2rem;
            color: #3d8bff;
            font-weight: 600;
            margin-left: 0.5rem;
        }

        .legend-change {
            color: #1ecb6b;
            font-weight: 600;
            margin-left: 10px;
        }

        .linechart {
            width: 100%;
            max-width: 360px;
            height: 120px;
            display: block;
        }

        .linechart .x-labels text {
            font-family: "Inter", sans-serif;
            font-size: 12px;
            fill: #b0b6c3;
        }

        .dot-group .tooltip {
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s;
        }

        .dot-group:hover .tooltip {
            opacity: 1;
        }

        .dot-group .tooltip rect {
            fill: #232733;
            stroke: #232733;
            stroke-width: 1.2;
            filter: drop-shadow(0 4px 16px rgba(0, 0, 0, 0.22));
            rx: 8;
            opacity: 0.92;
        }

        .dot-group .tooltip text {
            font-family: "Inter", sans-serif;
            font-size: 15px;
            font-weight: 500;
            fill: #fff;
            letter-spacing: 0.2px;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.18);
        }

        .menu-wrapper {
            position: relative;
            display: inline-block;
            margin-right: 4px;
        }

        .menu-dots {
            display: flex;
            flex-direction: column;
            gap: 3px;
            cursor: pointer;
            width: 18px;
            align-items: center;
            margin: 0 8px;
        }

        .menu-dots span {
            display: block;
            width: 5px;
            height: 5px;
            background: #6c7383;
            border-radius: 50%;
            transition: background 0.2s;
        }

        .menu-toggle {
            display: none;
        }

        .menu-select {
            display: none;
            position: absolute;
            right: 0;
            top: 30px;
            min-width: 110px;
            z-index: 10;
            padding: 8px 0;
            border-radius: 18px;
            border: 1.5px solid rgba(80, 90, 120, 0.18);
            background: rgba(30, 34, 44, 0.72);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.18);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            transition:
                opacity 0.25s cubic-bezier(0.4, 2, 0.6, 1),
                transform 0.25s cubic-bezier(0.4, 2, 0.6, 1);
            opacity: 0;
            transform: scale(0.95) translateY(-8px);
            pointer-events: none;
        }

        .menu-toggle:checked+.menu-dots+.menu-select {
            display: block;
            opacity: 1;
            transform: scale(1) translateY(0);
            pointer-events: auto;
        }

        .menu-select div {
            padding: 10px 20px 10px 16px;
            color: #f3f6fa;
            cursor: pointer;
            font-size: 15px;
            font-family: "Inter", sans-serif;
            border-left: 3px solid transparent;
            margin-bottom: 2px;
            border-radius: 8px;
            transition:
                background 0.18s,
                color 0.18s,
                border-left 0.18s;
        }

        .menu-select div:nth-child(1) {
            border-left: 3px solid #3d8bff;
        }

        .menu-select div:nth-child(2) {
            border-left: 3px solid #ff6a3d;
        }

        .menu-select div:nth-child(3) {
            border-left: 3px solid #1ecb6b;
        }

        .menu-select div:hover {
            background: rgba(61, 139, 255, 0.08);
            color: #3d8bff;
            border-left: 3px solid #3d8bff;
        }

        .menu-select div:nth-child(2):hover {
            background: rgba(255, 106, 61, 0.08);
            color: #ff6a3d;
            border-left: 3px solid #ff6a3d;
        }

        .menu-select div:nth-child(3):hover {
            background: rgba(30, 203, 107, 0.08);
            color: #1ecb6b;
            border-left: 3px solid #1ecb6b;
        }

        .stat-card-legend .legend-item:first-child {
            font-size: 0.95rem;
            color: #b8c0cc;
            font-weight: 400;
            letter-spacing: 0.01em;
        }
    </style>
    <div class="p-4">
        <div class="container-fluid ">
            <h1 class="h3 mb-4"> DashBoard</h1>
            {{-- تم استبدال div class="d-flex justify-content-around" بـ div class="row" --}}
            <div class="row ">
                {{-- new2 - Total Orders --}}
                {{-- تم تعديل فئة العمود إلى col-lg-3 col-md-6 col-12 --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-primary">
                        <div class="inner">
                            <h3>{{ $stats['total_orders'] }}</h3>
                            <p>Total Orders</p>
                        </div>
                        {{-- أيقونة السلة (Shopping Cart) --}}
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path
                                d="M2.25 2.25a.75.75 0 000 1.5h1.386c.17 0 .318.114.362.278l2.558 9.592a3.752 3.752 0 00-2.806 3.63c0 .414.336.75.75.75h15.75a.75.75 0 000-1.5H5.378A2.25 2.25 0 017.5 15h11.218a.75.75 0 00.674-.421 60.358 60.358 0 002.96-7.228.75.75 0 00-.525-.965A60.864 60.864 0 005.68 4.509l-.232-.867A1.875 1.875 0 003.636 2.25H2.25zM3.75 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0zM16.5 20.25a1.5 1.5 0 113 0 1.5 1.5 0 01-3 0z">
                            </path>
                        </svg>
                        <a href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
                {{-- new4 - Unique Visitors --}}
                {{-- تم تعديل فئة العمود إلى col-lg-3 col-md-6 col-12 --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-danger">
                        <div class="inner">
                            <h3>65</h3>
                            <p>Unique Visitors</p>
                        </div>
                        {{-- أيقونة المخطط الدائري (Chart Pie) --}}
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z">
                            </path>
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z">
                            </path>
                        </svg>
                        <a href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
                {{-- new3 - Bounce Rate --}}
                {{-- تم تعديل فئة العمود إلى col-lg-3 col-md-6 col-12 --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-success">
                        <div class="inner">
                            <h3>53<sup class="fs-5">%</sup></h3>
                            <p>Bounce Rate</p>
                        </div>
                        {{-- أيقونة الأعمدة (Bar Chart) --}}
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M18.375 2.25c-1.035 0-1.875.84-1.875 1.875v15.75c0 1.035.84 1.875 1.875 1.875h.75c1.035 0 1.875-.84 1.875-1.875V4.125c0-1.036-.84-1.875-1.875-1.875h-.75zM9.75 8.625c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v11.25c0 1.035-.84 1.875-1.875 1.875h-.75a1.875 1.875 0 01-1.875-1.875V8.625zM3 13.125c0-1.036.84-1.875 1.875-1.875h.75c1.036 0 1.875.84 1.875 1.875v6.75c0 1.035-.84 1.875-1.875 1.875h-.75A1.875 1.875 0 013 19.875v-6.75z">
                            </path>
                        </svg>
                        <a href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
                {{-- new1 - User Registrations --}}
                {{-- تم تعديل فئة العمود إلى col-lg-3 col-md-6 col-12 --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-warning">
                        <div class="inner">
                            <h3>44</h3>
                            <p>User Registrations</p>
                        </div>
                        {{-- أيقونة إضافة مستخدم (User Plus) --}}
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path
                                d="M6.25 6.375a4.125 4.125 0 118.25 0 4.125 4.125 0 01-8.25 0zM3.25 19.125a7.125 7.125 0 0114.25 0v.003l-.001.119a.75.75 0 01-.363.63 13.067 13.067 0 01-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 01-.364-.63l-.001-.122zM19.75 7.5a.75.75 0 00-1.5 0v2.25H16a.75.75 0 000 1.5h2.25v2.25a.75.75 0 001.5 0v-2.25H22a.75.75 0 000-1.5h-2.25V7.5z">
                            </path>
                        </svg>
                        <a href="#"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
            </div>

            <li <div class="row mt-4 ">
                {{-- Total Products --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-info">
                        <div class="inner">
                            <h3>{{ $stats['total_products'] }}</h3> {{-- يفترض أن 8 هو إجمالي المنتجات --}}
                            <p>Total Products</p>
                        </div>
                        {{-- أيقونة المنتجات (Boxes) --}}
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" aria-hidden="true">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M3 2.25a.75.75 0 01.75.75v.516l14.85 3.328a.75.75 0 01.536.842l-1.35 4.864a.75.75 0 01-.842.536L3.75 4.316V18.75a.75.75 0 001.5 0V5.992l12.75 2.85V18.75a.75.75 0 001.5 0V7.5a.75.75 0 00-.088-.387L5.006 3.006a.75.75 0 00-.638-.114L3.75 2.516V3A.75.75 0 013 3z">
                            </path>
                        </svg>
                        <a href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>

                {{-- Total Categories --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-secondary">
                        <div class="inner">
                            <h3>{{ $stats['total_categories'] }}</h3> {{-- يفترض أن 4 هو إجمالي الفئات --}}
                            <p>Total Categories</p>
                        </div>
                        {{-- أيقونة الفئات (Tags) --}}
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" aria-hidden="true">
                            <path
                                d="M5.625 1.5H9.75a.75.75 0 01.75.75v10.5a.75.75 0 01-1.5 0V7.31c-.35-.134-.727-.247-1.127-.34a10.05 10.05 0 00-3.136-.395l-.75-.025A.75.75 0 013 6.475v-4.5A.75.75 0 013.75 1.5h1.875zM12.75 3a.75.75 0 01.75-.75h3.375c.621 0 1.125.504 1.125 1.125v7.5a.75.75 0 01-1.5 0V4.5H13.5v15h-.75V19.5a.75.75 0 01-1.5 0V7.5h-1.5V6h1.5V4.5a1.5 1.5 0 011.5-1.5z">
                            </path>
                        </svg>
                        <a href="#"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>

                {{-- Total Admins --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-dark">
                        <div class="inner">
                            <h3>{{ $stats['total_users'] }}</h3> {{-- يفترض أن 12 هو إجمالي الإداريين --}}
                            <p>Total Users</p>
                        </div>
                        {{-- أيقونة الإداريين/الأشخاص (Users) --}}
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" aria-hidden="true">
                            <path
                                d="M11.5 13.5a6 6 0 10-6 6h12a6 6 0 10-6-6zM12 2.25a.75.75 0 01.75.75v.75a.75.75 0 01-1.5 0V3a.75.75 0 01.75-.75zM4.5 9a.75.75 0 01.75-.75h.75a.75.75 0 010 1.5h-.75A.75.75 0 014.5 9zM18 9a.75.75 0 01.75-.75h.75a.75.75 0 010 1.5h-.75A.75.75 0 0118 9zM6.5 13.5a.75.75 0 00-.75.75v.75a.75.75 0 001.5 0v-.75a.75.75 0 00-.75-.75zM16.5 13.5a.75.75 0 00-.75.75v.75a.75.75 0 001.5 0v-.75a.75.75 0 00-.75-.75z">
                            </path>
                        </svg>
                        <a href="#"
                            class="small-box-footer link-light link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>

                {{-- Total Visitors --}}
                <div class="col-lg-3 col-md-6 col-12">
                    <div class="small-box text-bg-light">
                        <div class="inner">
                            <h3>4</h3> {{-- يفترض أن 4 هو إجمالي الزيارات --}}
                            <p>Total Visitors</p>
                        </div>
                        {{-- أيقونة الزيارات (Eye) --}}
                        <svg class="small-box-icon" fill="currentColor" viewBox="0 0 24 24"
                            xmlns="[http://www.w3.org/2000/svg](http://www.w3.org/2000/svg)" aria-hidden="true">
                            <path
                                d="M12 4.5c-4.41 0-8 3.59-8 8s3.59 8 8 8 8-3.59 8-8-3.59-8-8-8zM12 18.5c-3.59 0-6.5-2.91-6.5-6.5s2.91-6.5 6.5-6.5 6.5 2.91 6.5 6.5-2.91 6.5-6.5 6.5zM12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM12 15c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z">
                            </path>
                        </svg>
                        <a href="#"
                            class="small-box-footer link-dark link-underline-opacity-0 link-underline-opacity-50-hover">
                            More info <i class="bi bi-link-45deg"></i>
                        </a>
                    </div>
                </div>
        </div>
        {{-- <hr class="my-4 border-light opacity-50"> --}}
        @include('partials.charts')
        @include('partials.graph')
        <!-- Recent Orders -->
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
                                        <a href="{{ route('admin.orders.show', $order) }}"
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

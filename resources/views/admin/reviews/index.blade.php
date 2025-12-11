@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Reviews Management</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Reviews</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Stats Cards -->
            <div class="row mb-4">
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: #17a2b8;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>{{ $reviews->total() }}</h2>
                            </div>
                            <p class="stat-card-title">Total Reviews</p>
                        </div>
                        <div class="stat-card-icon-area">
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: #28a745;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>{{ $reviews->where('approved', true)->count() }}</h2>
                            </div>
                            <p class="stat-card-title">Approved Reviews</p>
                        </div>
                        <div class="stat-card-icon-area">
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: #ffc107;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>{{ $reviews->where('approved', false)->count() }}</h2>
                            </div>
                            <p class="stat-card-title">Pending Reviews</p>
                        </div>
                        <div class="stat-card-icon-area">
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card" style="background: #6f42c1;">
                        <div class="stat-card-content">
                            <div class="stat-card-header">
                                <h2>{{ number_format($reviews->avg('rating'), 1) }}</h2>
                            </div>
                            <p class="stat-card-title">Average Rating</p>
                        </div>
                        <div class="stat-card-icon-area">
                            <svg class="stat-card-icon" fill="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters and Search -->
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.reviews.index') }}">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Search reviews..."
                                        name="search" value="{{ request('search') }}">
                                    <button class="btn btn-outline-primary" type="submit">
                                        <i class="bi bi-search"></i> Search
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <form method="GET" action="{{ route('admin.reviews.index') }}">
                                <div class="input-group">
                                    <select class="form-select" name="status" onchange="this.form.submit()">
                                        <option value="">All Status</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>
                                            Approved</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>
                                            Pending</option>
                                    </select>
                                    <select class="form-select" name="rating" onchange="this.form.submit()">
                                        <option value="">All Ratings</option>
                                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>5 Stars
                                        </option>
                                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>4 Stars
                                        </option>
                                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>3 Stars
                                        </option>
                                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>2 Stars
                                        </option>
                                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>1 Star
                                        </option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reviews Table -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-star me-2"></i>Reviews List
                    </h6>
                </div>
                <div class="card-body">
                    @if ($reviews->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Product</th>
                                        <th>Customer</th>
                                        <th>Rating</th>
                                        <th>Comment</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reviews as $review)
                                        <tr>
                                            <td>
                                                <span class="badge bg-secondary">#{{ $review->id }}</span>
                                            </td>
                                            <td>
                                                @if ($review->product)
                                                    <div class="d-flex align-items-center">
                                                        @if ($review->product->image)
                                                            <img src="{{ asset('Photo/' . $review->product->image) }}"
                                                                alt="{{ $review->product->name }}" class="rounded me-2"
                                                                style="width: 40px; height: 40px; object-fit: cover;">
                                                        @endif
                                                        <div>
                                                            <strong>{{ Str::limit($review->product->name, 30) }}</strong>
                                                            <br>
                                                            <small
                                                                class="text-muted">${{ number_format($review->product->price, 2) }}</small>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Product Deleted</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($review->user)
                                                    <div>
                                                        <strong>{{ $review->user->name }}</strong>
                                                        <br>
                                                        <small class="text-muted">{{ $review->user->email }}</small>
                                                    </div>
                                                @else
                                                    <span class="text-muted">User Deleted</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="text-warning me-2">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            <i
                                                                class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <span class="badge bg-primary">{{ $review->rating }}/5</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-truncate" style="max-width: 200px;"
                                                    title="{{ $review->comment }}">
                                                    {{ Str::limit($review->comment, 50) }}
                                                </div>
                                            </td>
                                            <td>
                                                @if ($review->approved)
                                                    <span class="badge bg-success">
                                                        <i class="bi bi-check-circle me-1"></i>Approved
                                                    </span>
                                                @else
                                                    <span class="badge bg-warning">
                                                        <i class="bi bi-clock me-1"></i>Pending
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $review->created_at->format('M d, Y') }}</small>
                                                <br>
                                                <small class="text-muted">{{ $review->created_at->format('H:i') }}</small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    @if (!$review->approved)
                                                        <form action="{{ route('admin.reviews.update', $review) }}"
                                                            method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="action" value="approve">
                                                            <button type="submit" class="btn btn-sm btn-success"
                                                                title="Approve Review">
                                                                <i class="bi bi-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    <button type="button" class="btn btn-sm btn-info"
                                                        title="View Details" data-bs-toggle="modal"
                                                        data-bs-target="#reviewModal{{ $review->id }}">
                                                        <i class="bi bi-eye"></i>
                                                    </button>
                                                    <form action="{{ route('admin.reviews.destroy', $review) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this review?')"
                                                            title="Delete Review">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $reviews->links() }}
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-star" style="font-size: 3rem; color: #ccc;"></i>
                            <h5 class="mt-3 text-muted">No reviews found</h5>
                            <p class="text-muted">Reviews will appear here once customers start rating products.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Review Detail Modals -->
    @foreach ($reviews as $review)
        <div class="modal fade" id="reviewModal{{ $review->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Review Details #{{ $review->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>Product Information</h6>
                                @if ($review->product)
                                    <div class="d-flex align-items-center mb-3">
                                        @if ($review->product->image)
                                            <img src="{{ asset('Photo/' . $review->product->image) }}"
                                                alt="{{ $review->product->name }}" class="rounded me-3"
                                                style="width: 80px; height: 80px; object-fit: cover;">
                                        @endif
                                        <div>
                                            <h6 class="mb-1">{{ $review->product->name }}</h6>
                                            <p class="mb-0 text-muted">${{ number_format($review->product->price, 2) }}
                                            </p>
                                        </div>
                                    </div>
                                @else
                                    <p class="text-muted">Product has been deleted</p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h6>Customer Information</h6>
                                @if ($review->user)
                                    <div>
                                        <h6 class="mb-1">{{ $review->user->name }}</h6>
                                        <p class="mb-1 text-muted">{{ $review->user->email }}</p>
                                        <p class="mb-0 text-muted">Member since
                                            {{ $review->user->created_at->format('M Y') }}</p>
                                    </div>
                                @else
                                    <p class="text-muted">User has been deleted</p>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="row">
                            <div class="col-md-4">
                                <h6>Rating</h6>
                                <div class="text-warning mb-2">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= $review->rating ? '-fill' : '' }}"></i>
                                    @endfor
                                </div>
                                <span class="badge bg-primary">{{ $review->rating }}/5</span>
                            </div>
                            <div class="col-md-4">
                                <h6>Status</h6>
                                @if ($review->approved)
                                    <span class="badge bg-success">Approved</span>
                                @else
                                    <span class="badge bg-warning">Pending Approval</span>
                                @endif
                            </div>
                            <div class="col-md-4">
                                <h6>Date</h6>
                                <p class="mb-0">{{ $review->created_at->format('F d, Y \a\t H:i') }}</p>
                            </div>
                        </div>

                        <hr>

                        <h6>Review Comment</h6>
                        <div class="bg-light p-3 rounded">
                            <p class="mb-0">{{ $review->comment }}</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        @if (!$review->approved)
                            <form action="{{ route('admin.reviews.update', $review) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="action" value="approve">
                                <button type="submit" class="btn btn-success">
                                    <i class="bi bi-check-circle me-2"></i>Approve Review
                                </button>
                            </form>
                        @endif
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <style>
        .stat-card {
            background: purple;
            border-radius: 12px;
            box-shadow: 0 2px 10px 0 rgba(0, 0, 0, 0.1);
            padding: 0.75rem 1rem;
            color: #f3f6fa;
            display: flex;
            align-items: center;
            height: 100%;
            transition: transform 0.2s;
        }

        .stat-card:hover {
            transform: translateY(-2px);
        }

        .stat-card-content {
            flex-grow: 1;
            padding-right: 10px;
        }

        .stat-card-header h2 {
            font-family: "Inter", sans-serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: #fff;
            margin: 0;
            line-height: 1;
            text-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .stat-card-title {
            font-family: "Inter", sans-serif;
            font-size: 0.9rem;
            font-weight: 500;
            color: rgba(255, 255, 255, 0.9);
            margin: 0;
            line-height: 1.2;
            opacity: 0.9;
        }

        .stat-card-icon-area {
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .stat-card-icon {
            width: 50px;
            height: 50px;
            color: rgba(255, 255, 255, 0.85);
            filter: drop-shadow(0 2px 5px rgba(0, 0, 0, 0.1));
            opacity: 0.9;
        }

        .table {
            color: #2c3e50;
        }

        .table th {
            border-top: none;
            font-weight: 600;
            color: #2c3e50;
            background-color: #f8f9fa;
        }

        .card {
            border: none;
            border-radius: 12px;
            background-color: white;
            color: #2c3e50;
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
        }

        .card-body {
            color: #2c3e50;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        label,
        small,
        div,
        span {
            color: #2c3e50;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .breadcrumb {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            padding: 0.5rem 1rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .breadcrumb-item.active {
            color: #6c757d;
            font-weight: 600;
        }

        .alert {
            color: #2c3e50;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .btn-group .btn {
            margin-right: 2px;
        }

        .modal-content {
            border: none;
            border-radius: 12px;
        }

        .modal-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px 12px 0 0;
        }

        .modal-header .btn-close {
            filter: invert(1);
        }
    </style>
@endsection

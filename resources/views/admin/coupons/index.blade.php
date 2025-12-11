@extends('layouts.admin')

@section('styles')
    <style>
        .coupon-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            border: 1px solid rgba(33, 150, 243, 0.2);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.1);
            transition: all 0.3s ease;
        }

        .coupon-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(33, 150, 243, 0.2);
            border-color: rgba(33, 150, 243, 0.4);
        }

        .form-label {
            color: #2196f3 !important;
            font-weight: 600;
        }

        .form-control {
            border: 2px solid rgba(33, 150, 243, 0.3);
            border-radius: 8px;
            color: #333;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
            color: #333;
        }

        .btn-primary {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #1976d2 0%, #2196f3 100%);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.4);
        }

        .table {
            color: #333;
        }

        .table th {
            color: #2196f3 !important;
            font-weight: 700;
            border-color: rgba(33, 150, 243, 0.3);
            background-color: rgba(33, 150, 243, 0.05);
        }

        .table td {
            border-color: rgba(33, 150, 243, 0.2);
            vertical-align: middle;
        }

        .badge-success {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
        }

        .badge-danger {
            background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        }

        .card-header {
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(40, 167, 69, 0.1) 100%);
            border-bottom: 2px solid rgba(33, 150, 243, 0.3);
            color: #2196f3 !important;
            font-weight: 700;
        }

        .text-muted {
            color: #6c757d !important;
        }

        .btn-sm {
            border-radius: 6px;
            font-weight: 500;
        }

        .modal-content {
            border-radius: 15px;
            border: 2px solid rgba(33, 150, 243, 0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(40, 167, 69, 0.1) 100%);
            border-bottom: 2px solid rgba(33, 150, 243, 0.3);
            color: #2196f3 !important;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(40, 167, 69, 0.1) 0%, rgba(32, 201, 151, 0.1) 100%);
            border: 1px solid rgba(40, 167, 69, 0.3);
            color: #155724;
            border-radius: 8px;
        }

        .coupon-code {
            background: linear-gradient(135deg, #2196f3 0%, #1976d2 100%);
            color: white;
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            font-weight: bold;
            font-family: 'Courier New', monospace;
        }

        .expired-text {
            color: #dc3545 !important;
            font-weight: 600;
        }

        .usage-counter {
            background: rgba(33, 150, 243, 0.1);
            padding: 0.25rem 0.5rem;
            border-radius: 6px;
            color: #2196f3;
            font-weight: 600;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-center" style="color: #white;">Coupon Management</h1>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="card shadow coupon-card rounded-5">
                    <div class="card-header " style="background-color:#2196f3">
                        <h6 class="m-0 font-weight-bold text-white text-center fs-3 ">Add New Coupon</h6>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.coupons.store') }}" method="POST">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="code" class="form-label" style="color: #2196f3">Coupon Code *</label>
                                <input type="text" class="form-control @error('code') is-invalid @enderror"
                                    id="code" name="code" value="{{ old('code') }}" required>
                                @error('code')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="discount_percent" class="form-label" style="color: #2196f3">Discount Percentage
                                    % *</label>
                                <input type="number" class="form-control @error('discount_percent') is-invalid @enderror"
                                    id="discount_percent" name="discount_percent" value="{{ old('discount_percent', 10) }}"
                                    min="1" max="100" required>
                                @error('discount_percent')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="user_id" class="form-label"style="color: #2196f3">Assigned to User
                                    (Optional)</label>
                                <select class="form-control @error('user_id') is-invalid @enderror" id="user_id"
                                    name="user_id">
                                    <option value="">All Users</option>
                                    @foreach ($users as $user)
                                        <option value="{{ $user->id }}"
                                            {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }} ({{ $user->email }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('user_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="expires_at" class="form-label" style="color: #2196f3">Expiration Date
                                    (Optional)</label>
                                <input type="datetime-local" class="form-control @error('expires_at') is-invalid @enderror"
                                    id="expires_at" name="expires_at" value="{{ old('expires_at') }}">
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group mb-3">
                                <label for="max_uses" class="form-label" style="color: #2196f3">Maximum Uses
                                    (Optional)</label>
                                <input type="number" class="form-control @error('max_uses') is-invalid @enderror"
                                    id="max_uses" name="max_uses" value="{{ old('max_uses') }}" min="1">
                                @error('max_uses')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-block w-100 text-light rounded-5"
                                style="background-color: #28a745;">Create
                                Coupon</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="card shadow coupon-card">
                    <div class="card-header">
                        <h6 class="m-0 font-weight-bold">Coupon List</h6>
                    </div>
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Code</th>
                                        <th>Discount %</th>
                                        <th>Expiration Date</th>
                                        <th>Usage Count</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $coupon)
                                        <tr>
                                            <td>
                                                <span class="coupon-code">{{ $coupon->code }}</span>
                                                @if ($coupon->user)
                                                    <br><small class="text-muted">For: {{ $coupon->user->name }}</small>
                                                @endif
                                            </td>
                                            <td>{{ $coupon->discount_percent }}%</td>
                                            <td>
                                                @if ($coupon->expires_at)
                                                    {{ $coupon->expires_at->format('Y-m-d') }}
                                                    @if ($coupon->expires_at->isPast())
                                                        <br><small class="expired-text">Expired</small>
                                                    @endif
                                                @else
                                                    <span class="text-muted">No Expiration</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coupon->max_uses)
                                                    <span class="usage-counter">{{ $coupon->used_count ?? 0 }} /
                                                        {{ $coupon->max_uses }}</span>
                                                @else
                                                    <span class="text-muted">Unlimited</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if ($coupon->is_active)
                                                    <span class="badge bg-success">Active</span>
                                                @else
                                                    <span class="badge bg-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-sm btn-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editCouponModal{{ $coupon->id }}">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <form action="{{ route('admin.coupons.destroy', $coupon) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-danger"
                                                            onclick="return confirm('Are you sure you want to delete this coupon?')">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>

                                        <!-- Edit Modal -->
                                        <div class="modal fade" id="editCouponModal{{ $coupon->id }}" tabindex="-1"
                                            role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <form action="{{ route('admin.coupons.update', $coupon) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"style="color: black">Edit Coupon
                                                                {{ $coupon->code }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="form-group mb-3">
                                                                <label class="form-label"style="color: #1976d2">Coupon
                                                                    Code</label>
                                                                <input type="text" class="form-control" name="code"
                                                                    value="{{ $coupon->code }}" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label"style="color: #1976d2">Discount
                                                                    Percentage %</label>
                                                                <input type="number" class="form-control"
                                                                    name="discount_percent"
                                                                    value="{{ $coupon->discount_percent }}"
                                                                    min="1" max="100" required>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label"style="color: #1976d2">Assigned to
                                                                    User</label>
                                                                <select class="form-control" name="user_id">
                                                                    <option value="">All Users</option>
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->id }}"
                                                                            {{ $coupon->user_id == $user->id ? 'selected' : '' }}>
                                                                            {{ $user->name }} ({{ $user->email }})
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label"style="color: #1976d2">Expiration
                                                                    Date</label>
                                                                <input type="datetime-local" class="form-control"
                                                                    name="expires_at"
                                                                    value="{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d\TH:i') : '' }}">
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <label class="form-label" style="color: #1976d2">Maximum
                                                                    Uses</label>
                                                                <input type="number" class="form-control"
                                                                    name="max_uses" value="{{ $coupon->max_uses }}"
                                                                    min="1">
                                                            </div>
                                                            <div class="form-group mb-3">
                                                                <div class="form-check">
                                                                    <input type="checkbox" class="form-check-input"
                                                                        name="is_active" value="1"
                                                                        {{ $coupon->is_active ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        style="color: #1976d2">Coupon is
                                                                        Active</label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Update</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

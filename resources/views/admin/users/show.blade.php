@extends('layouts.admin')

@section('title', 'User Details')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title text-dark">
                            <i class="fas fa-user mr-2 "></i>
                            User Details
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Users
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 text-dark">Personal Information</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="text-center mb-4">
                                            @if ($user->profile_photo_url)
                                                <img src="{{ $user->profile_photo_url }}" alt="Profile Photo"
                                                    class="rounded-circle mb-3" width="120" height="120">
                                            @else
                                                <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 120px; height: 120px;">
                                                    <i class="fas fa-user fa-3x text-white"></i>
                                                </div>
                                            @endif
                                            <h4 class="text-dark">{{ $user->name }}</h4>
                                            @if ($user->is_admin)
                                                <span class="badge bg-danger badge-lg">Administrator</span>
                                            @else
                                                <span class="badge bg-info badge-lg">Customer</span>
                                            @endif
                                        </div>

                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>User ID:</strong></td>
                                                <td><code>{{ $user->id }}</code></td>
                                            </tr>
                                            <tr>
                                                <td><strong>Full Name:</strong></td>
                                                <td>{{ $user->name }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Email:</strong></td>
                                                <td>
                                                    <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Role:</strong></td>
                                                <td>
                                                    @if ($user->is_admin)
                                                        <span class="badge bg-danger">Administrator</span>
                                                    @else
                                                        <span class="badge bg-info">Customer</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if ($user->discount)
                                                <tr>
                                                    <td><strong>Discount:</strong></td>
                                                    <td>
                                                        <span class="badge badge-success">{{ $user->discount }}%</span>
                                                    </td>
                                                </tr>
                                            @endif
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 text-dark">Account Statistics</h5>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-borderless">
                                            <tr>
                                                <td><strong>Total Orders:</strong></td>
                                                <td>
                                                    <span class="h5 text-primary">
                                                        {{ $user->orders ? $user->orders->count() : 0 }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Total Spent:</strong></td>
                                                <td>
                                                    <span class="h5 text-success">
                                                        ${{ number_format($user->orders ? $user->orders->sum('total') : 0, 2) }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Active Cart Items:</strong></td>
                                                <td>
                                                    <span class="h5 text-info">
                                                        {{ $user->cart ? $user->cart->items->count() : 0 }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Reviews Written:</strong></td>
                                                <td>
                                                    <span class="h5 text-warning">
                                                        {{ $user->reviews ? $user->reviews->count() : 0 }}
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><strong>Account Created:</strong></td>
                                                <td>{{ $user->created_at->format('M j, Y g:i:s A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Last Updated:</strong></td>
                                                <td>{{ $user->updated_at->format('M j, Y g:i:s A') }}</td>
                                            </tr>
                                            <tr>
                                                <td><strong>Member Since:</strong></td>
                                                <td>{{ $user->created_at->diffForHumans() }}</td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Orders Section -->
                        @if ($user->orders && $user->orders->count() > 0)
                            <div class="row mt-4">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0">Recent Orders</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-bordered table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>Order ID</th>
                                                            <th>Total</th>
                                                            <th>Status</th>
                                                            <th>Date</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($user->orders->take(5) as $order)
                                                            <tr>
                                                                <td><code>#{{ $order->id }}</code></td>
                                                                <td><strong>${{ number_format($order->total, 2) }}</strong>
                                                                </td>
                                                                <td>
                                                                    @if ($order->status === 'completed')
                                                                        <span class="badge bg-success">Completed</span>
                                                                    @elseif($order->status === 'pending')
                                                                        <span class="badge bg-warning">Pending</span>
                                                                    @elseif($order->status === 'cancelled')
                                                                        <span class="badge bg-danger">Cancelled</span>
                                                                    @else
                                                                        <span
                                                                            class="badge bg-info">{{ ucfirst($order->status) }}</span>
                                                                    @endif
                                                                </td>
                                                                <td>{{ $order->created_at->format('M j, Y') }}</td>
                                                                <td>
                                                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                                                        class="btn btn-sm btn-outline-info">
                                                                        View
                                                                    </a>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                            @if ($user->orders->count() > 5)
                                                <div class="text-center mt-3">
                                                    <a href="{{ route('admin.orders.index') }}?user_id={{ $user->id }}"
                                                        class="btn btn-outline-primary">
                                                        View All {{ $user->orders->count() }} Orders
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- User Actions -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h5 class="mb-0 text-dark">Actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i> Edit User
                                            </a>

                                            @if ($user->id !== auth()->id())
                                                <button type="button" class="btn btn-danger"
                                                    onclick="deleteUser({{ $user->id }})">
                                                    <i class="fas fa-trash"></i> Delete User
                                                </button>
                                            @endif

                                            <button type="button" class="btn btn-secondary" onclick="window.print()">
                                                <i class="fas fa-print"></i> Print Details
                                            </button>

                                            <a href="mailto:{{ $user->email }}" class="btn btn-info">
                                                <i class="fas fa-envelope"></i> Send Email
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Deletion</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this user?</p>
                    <div class="alert alert-warning">
                        <strong>Warning:</strong> This action cannot be undone and will remove all associated data including
                        orders, cart items, and reviews.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDelete">Delete User</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        let userToDelete = null;

        function deleteUser(id) {
            userToDelete = id;
            $('#deleteUserModal').modal('show');
        }

        $('#confirmDelete').click(function() {
            if (userToDelete) {
                // Create and submit a form for deletion
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/admin/users/${userToDelete}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';

                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        });
    </script>
@endsection

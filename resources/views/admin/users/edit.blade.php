@extends('layouts.admin')

@section('title', 'Edit User')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title " style="color: #1976d2 ">
                            <i class="fas fa-user-edit mr-2"></i>
                            Edit User
                        </h3>
                        <div class="card-tools">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn btn-info btn-sm">
                                <i class="fas fa-eye"></i> View Details
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-arrow-left"></i> Back to Users
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">
                                <!-- User Profile Section -->
                                <div class="col-md-4">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0 text-dark">Profile Photo</h5>
                                        </div>
                                        <div class="card-body text-center">
                                            @if ($user->profile_photo_url)
                                                <img src="{{ $user->profile_photo_url }}" alt="Current Photo"
                                                    class="img-fluid mb-3"
                                                    style="max-width: 200px; max-height: 200px; object-fit: cover;">
                                            @else
                                                <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                                                    style="width: 150px; height: 150px; font-size: 3rem; font-weight: bold;">
                                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                                </div>
                                            @endif

                                            <div class="form-group">
                                                <label for="profile_photo">Change Photo</label>
                                                <input type="file" class="form-control-file" id="profile_photo"
                                                    name="profile_photo" accept="image/*">
                                                <small class="form-text text-muted">Max file size: 2MB. Supported formats:
                                                    JPG, PNG, GIF</small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Status -->
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h5 class="mb-0 text-dark">Account Status</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="is_admin"
                                                        name="is_admin" value="1"
                                                        {{ $user->is_admin ? 'checked' : '' }}>
                                                    <label class="custom-control-label text-dark" for="is_admin">
                                                        Administrator Privileges
                                                    </label>
                                                </div>
                                                <small class="form-text text-muted">Grant admin access to this user</small>
                                            </div>

                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="is_active"
                                                        name="is_active" value="1"
                                                        {{ $user->is_active ? 'checked' : '' }}>
                                                    <label class="custom-control-label text-dark" for="is_active">
                                                        Active Account
                                                    </label>
                                                </div>
                                                <small class="form-text text-muted">Deactivate to prevent user login</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- User Information Form -->
                                <div class="col-md-8">
                                    <div class="card">
                                        <div class="card-header">
                                            <h5 class="mb-0 text-dark">Personal Information</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="name" class="text-dark">Full Name *</label>
                                                        <input type="text"
                                                            class="form-control @error('name') is-invalid @enderror"
                                                            id="name" name="name"
                                                            value="{{ old('name', $user->name) }}" required>
                                                        @error('name')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="username" class="text-dark">Username</label>
                                                        <input type="text"
                                                            class="form-control @error('username') is-invalid @enderror"
                                                            id="username" name="username"
                                                            value="{{ old('username', $user->username) }}">
                                                        <small class="form-text text-muted">Optional - for display
                                                            purposes</small>
                                                        @error('username')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="email" class="text-dark">Email Address *</label>
                                                        <input type="email"
                                                            class="form-control @error('email') is-invalid @enderror"
                                                            id="email" name="email"
                                                            value="{{ old('email', $user->email) }}" required>
                                                        @error('email')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="phone" class="text-dark">Phone Number</label>
                                                        <input type="text"
                                                            class="form-control @error('phone') is-invalid @enderror"
                                                            id="phone" name="phone"
                                                            value="{{ old('phone', $user->phone) }}">
                                                        @error('phone')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Account Settings -->
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h5 class="mb-0 text-dark">Account Settings</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="discount" class="text-dark">Discount
                                                            Percentage</label>
                                                        <div class="input-group">
                                                            <input type="number"
                                                                class="form-control @error('discount') is-invalid @enderror"
                                                                id="discount" name="discount"
                                                                value="{{ old('discount', $user->discount ?? 0) }}"
                                                                min="0" max="100" step="0.01">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text">%
                                                            </div>
                                                        </div>
                                                        <small class="form-text text-muted">Discount applied</span>
                                                            to this user's orders</small>
                                                        @error('discount')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="text-dark">Email Verification</label>
                                                        <div class="mt-2">
                                                            @if ($user->email_verified_at)
                                                                <span class="badge bg-success">
                                                                    <i class="fas fa-check-circle"></i> Verified on
                                                                    {{ $user->email_verified_at->format('M j, Y') }}
                                                                </span>
                                                            @else
                                                                <span class="badge bg-warning">
                                                                    <i class="fas fa-exclamation-triangle"></i> Not
                                                                    verified
                                                                </span>
                                                                <button type="button"
                                                                    class="btn btn-sm btn-outline-primary ml-2"
                                                                    onclick="verifyEmail({{ $user->id }})">
                                                                    Verify Now
                                                                </button>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="bio" class="text-dark">Bio</label>
                                                        <textarea class="form-control @error('bio') is-invalid @enderror" id="bio" name="bio" rows="3"
                                                            placeholder="Tell us about this user...">{{ old('bio', $user->bio) }}</textarea>
                                                        @error('bio')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Security & Password -->
                                    <div class="card mt-3">
                                        <div class="card-header">
                                            <h5 class="mb-0 text-dark">Security & Password</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password " class="text-dark">New Password</label>
                                                        <input type="password"
                                                            class="form-control @error('password') is-invalid @enderror"
                                                            id="password" name="password">
                                                        <small class="form-text text-muted">Leave blank to keep current
                                                            password</small>
                                                        @error('password')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="password_confirmation" class="text-dark">Confirm
                                                            Password</label>
                                                        <input type="password" class="form-control"
                                                            id="password_confirmation" name="password_confirmation">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-12">
                                                    <button type="button" class="btn btn-warning"
                                                        onclick="resetPassword({{ $user->id }})">
                                                        <i class="fas fa-key"></i> Send Password Reset Email
                                                    </button>
                                                    <small class="form-text text-muted d-block mt-1">
                                                        This will send a password reset link to the user's email address
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="row">
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Save Changes
                                    </button>
                                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times"></i> Cancel
                                    </a>
                                </div>
                                <div class="col-md-6 text-right">
                                    <button type="button" class="btn btn-danger"
                                        onclick="deleteUser({{ $user->id }})">
                                        <i class="fas fa-trash"></i> Delete User
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
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
                    <div class="alert alert-danger">
                        <strong>Warning:</strong> This action cannot be undone and will permanently remove all user data.
                    </div>
                    <p><strong>User:</strong> {{ $user->name }} ({{ $user->email }})</p>
                    <p><strong>Impact:</strong> All orders, reviews, and account data will be permanently deleted.</p>
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

        function verifyEmail(userId) {
            if (confirm('Are you sure you want to manually verify this user\'s email address?')) {
                // Implement email verification functionality
                fetch(`/admin/users/${userId}/verify-email`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            location.reload();
                        } else {
                            alert('Failed to verify email. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            }
        }

        function resetPassword(userId) {
            if (confirm('Are you sure you want to send a password reset email to this user?')) {
                // Implement password reset functionality
                fetch(`/admin/users/${userId}/reset-password`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Password reset email sent successfully!');
                        } else {
                            alert('Failed to send password reset email. Please try again.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            }
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

        // Preview uploaded image
        document.getElementById('profile_photo').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.querySelector('.card-body img');
                    if (img) {
                        img.src = e.target.result;
                    }
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection

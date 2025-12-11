@extends('layouts.app')

@section('title', 'Profile Settings')

@section('styles')
    <style>
        .profile-container {
            background: rgba(255, 255, 255, 0.83);
            border-radius: 25px;
            padding: 2rem;
            margin: 2rem 0;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(33, 150, 243, 0.2);
        }

        .profile-header {
            text-align: center;
            margin-bottom: 3rem;
            padding: 2rem;
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(40, 167, 69, 0.1) 100%);
            border-radius: 20px;
            border: 2px solid rgba(33, 150, 243, 0.3);
        }

        .profile-image {
            border: 4px solid #2196f3;
            box-shadow: 0 0 30px rgba(33, 150, 243, 0.4);
            transition: all 0.3s ease;
            position: relative;
        }

        .profile-image:hover {
            transform: scale(1.05);
            box-shadow: 0 0 40px rgba(33, 150, 243, 0.6);
        }

        .profile-image::after {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            border: 2px solid rgba(33, 150, 243, 0.3);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.1);
                opacity: 0.7;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .section-title {
            color: #2196f3;
            font-family: 'Comic Sans MS', cursive;
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .form-section {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(33, 150, 243, 0.2);
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .form-section:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: rgba(33, 150, 243, 0.4);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .form-label {
            color: #2196f3;
            font-weight: bold;
            margin-bottom: 0.5rem;
            font-size: 1rem;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid rgba(33, 150, 243, 0.3);
            border-radius: 12px;
            color: #333;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(5px);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 1);
            border-color: #2196f3;
            box-shadow: 0 0 20px rgba(33, 150, 243, 0.3);
            color: #333;
        }

        .form-control::placeholder {
            color: #666;
        }

        .form-control:disabled {
            background: rgba(248, 249, 250, 0.8);
            color: #666;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: -9999px;
        }

        .file-input-label {
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(40, 167, 69, 0.1) 100%);
            border: 2px dashed rgba(33, 150, 243, 0.5);
            border-radius: 12px;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            display: block;
            color: #2196f3;
        }

        .file-input-label:hover {
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.2) 0%, rgba(40, 167, 69, 0.2) 100%);
            border-color: #2196f3;
            transform: translateY(-2px);
        }

        .form-text {
            color: #666;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }

        .btn-custom {
            background: linear-gradient(135deg, #2196f3 0%, #28a745 100%);
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
            position: relative;
            overflow: hidden;
        }

        .btn-custom::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .btn-custom:hover::before {
            left: 100%;
        }

        .btn-custom:hover {
            background: linear-gradient(135deg, #28a745 0%, #2196f3 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(33, 150, 243, 0.4);
            color: white;
        }

        .btn-secondary-custom {
            background: transparent;
            color: #2196f3;
            border: 2px solid #2196f3;
            padding: 0.75rem 2rem;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn-secondary-custom:hover {
            background: #2196f3;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(33, 150, 243, 0.3);
        }

        .alert {
            border-radius: 12px;
            border: none;
            padding: 1rem 1.5rem;
            margin-bottom: 2rem;
        }

        .alert-success {
            background: rgba(40, 167, 69, 0.1);
            color: #155724;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            color: #721c24;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }

        .badge-custom {
            background: linear-gradient(135deg, #2196f3 0%, #28a745 100%);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .divider {
            border-color: rgba(33, 150, 243, 0.3);
            margin: 2rem 0;
            height: 2px;
            background: linear-gradient(90deg, transparent, rgba(33, 150, 243, 0.5), transparent);
        }

        .form-row {
            margin-bottom: 1.5rem;
        }

        .profile-text {
            color: #333;
        }

        .profile-subtitle {
            color: #666;
        }

        @media (max-width: 768px) {
            .profile-container {
                padding: 1rem;
                margin: 1rem;
            }

            .form-section {
                padding: 1.5rem;
            }

            .profile-header {
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10 col-xl-8">
                <div class="profile-container">

                    {{-- Success/Error Messages --}}
                    @if (session('status') === 'profile-updated')
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>
                            Profile updated successfully!
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Please fix the following errors:</strong>
                            <ul class="mt-2 mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Profile Header --}}
                    <div class="profile-header">
                        <img src="{{ $user->profile_photo_url ?? 'https://via.placeholder.com/150?text=User' }}"
                            alt="Profile Image" class="rounded-circle profile-image"
                            style="width: 150px; height: 150px; object-fit: cover;">

                        <h2 class="section-title mt-3">{{ $user->name }}</h2>

                        @if ($user->is_admin ?? false)
                            <span class="badge-custom">
                                <i class="fas fa-crown me-1"></i>Admin
                            </span>
                        @else
                            <span class="badge-custom">
                                <i class="fas fa-user me-1"></i>User
                            </span>
                        @endif
                    </div>

                    {{-- Profile Update Form --}}
                    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
                        id="profile-form">
                        @csrf
                        @method('PUT')

                        {{-- Profile Picture Section --}}
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-camera me-2"></i>Update Profile Picture
                            </h4>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Upload New Photo</label>
                                    <div class="file-input-wrapper">
                                        <input type="file" id="profile_image_file" name="profile_image_file"
                                            accept="image/*">
                                        <label for="profile_image_file" class="file-input-label">
                                            <i class="fas fa-cloud-upload-alt fa-2x mb-2 d-block"></i>
                                            <strong>Click to Upload</strong><br>
                                            <small>Max size 2MB. JPG, PNG, GIF accepted.</small>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="profile_image_url" class="form-label">Or Enter Image URL</label>
                                    <input type="text" class="form-control" id="profile_image_url"
                                        name="profile_image_url" value="{{ old('profile_image_url') }}"
                                        placeholder="https://example.com/photo.jpg">
                                    <div class="form-text">Paste a direct link to the image.</div>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- Personal Information Section --}}
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-user me-2"></i>Personal Information
                            </h4>

                            <div class="row g-4">
                                <div class="col-md-6 form-row">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ old('name', $user->name) }}" required>
                                </div>

                                <div class="col-md-6 form-row">
                                    <label for="email" class="form-label">Email Address</label>
                                    <input type="email" class="form-control" id="email" name="email"
                                        value="{{ old('email', $user->email) }}" required>
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- Password Section --}}
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-lock me-2"></i>Change Password
                            </h4>

                            <div class="row g-4">
                                <div class="col-md-6 form-row">
                                    <label for="password" class="form-label">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Leave blank to keep current password">
                                    <div class="form-text">Minimum 6 characters required.</div>
                                </div>

                                <div class="col-md-6 form-row">
                                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" placeholder="Confirm new password">
                                </div>
                            </div>
                        </div>

                        <div class="divider"></div>

                        {{-- Account Info Section (Read Only) --}}
                        <div class="form-section">
                            <h4 class="section-title">
                                <i class="fas fa-info-circle me-2"></i>Account Information
                            </h4>

                            <div class="row g-4">
                                <div class="col-md-6">
                                    <label class="form-label">Member Since</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->created_at->format('Y-m-d') }}" readonly>
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">Last Updated</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->updated_at->format('Y-m-d H:i') }}" readonly>
                                </div>
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="text-center mt-4">
                            <a href="{{ url()->previous() }}" class="btn-secondary-custom me-3">
                                <i class="fas fa-arrow-left me-2"></i>Back
                            </a>
                            <button type="submit" class="btn-custom">
                                <i class="fas fa-save me-2"></i>Update Profile
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('profile_image_file');
            const urlInput = document.getElementById('profile_image_url');
            const fileLabel = document.querySelector('.file-input-label');

            // File input change handler
            fileInput.addEventListener('change', function() {
                if (fileInput.value) {
                    urlInput.value = '';
                    fileLabel.innerHTML =
                        '<i class="fas fa-check-circle fa-2x mb-2 d-block text-success"></i><strong>File Selected!</strong>';
                } else {
                    fileLabel.innerHTML =
                        '<i class="fas fa-cloud-upload-alt fa-2x mb-2 d-block"></i><strong>Click to Upload</strong><br><small>Max size 2MB. JPG, PNG, GIF accepted.</small>';
                }
            });

            // URL input handler
            urlInput.addEventListener('input', function() {
                if (urlInput.value) {
                    fileInput.value = '';
                    fileLabel.innerHTML =
                        '<i class="fas fa-link fa-2x mb-2 d-block"></i><strong>URL Entered</strong><br><small>Direct image link provided.</small>';
                } else {
                    fileLabel.innerHTML =
                        '<i class="fas fa-cloud-upload-alt fa-2x mb-2 d-block"></i><strong>Click to Upload</strong><br><small>Max size 2MB. JPG, PNG, GIF accepted.</small>';
                }
            });

            // Form submission enhancement
            const form = document.getElementById('profile-form');
            form.addEventListener('submit', function(e) {
                const submitBtn = form.querySelector('button[type="submit"]');
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Updating...';
                submitBtn.disabled = true;
            });
        });
    </script>
@endsection

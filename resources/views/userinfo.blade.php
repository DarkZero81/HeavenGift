@extends('layouts.app')

@section('title', 'User Profile')

@section('styles')
    <style>
        .userinfo-card {
            background: rgba(255, 107, 0, 0.1);
            border: 2px solid rgba(255, 107, 0, 0.3);
            border-radius: 20px;
            padding: 2rem;
            backdrop-filter: blur(10px);
            box-shadow: 0 8px 32px rgba(255, 107, 0, 0.2);
            transition: all 0.3s ease;
        }

        .userinfo-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 40px rgba(255, 107, 0, 0.3);
            border-color: rgba(255, 107, 0, 0.5);
        }

        .userinfo-title {
            color: #ff6b00;
            font-family: 'Comic Sans MS', cursive;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .userinfo-subtitle {
            color: #ff8c42;
            font-family: 'Comic Sans MS', cursive;
        }

        .info-field {
            background: rgba(255, 140, 66, 0.1);
            border: 1px solid rgba(255, 140, 66, 0.3);
            border-radius: 12px;
            padding: 1rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .info-field:hover {
            background: rgba(255, 140, 66, 0.2);
            border-color: rgba(255, 140, 66, 0.5);
            transform: translateX(5px);
        }

        .info-label {
            color: #ff6b00;
            font-weight: bold;
            margin-bottom: 0.5rem;
        }

        .info-value {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        .userinfo-btn-primary {
            background: linear-gradient(135deg, #ff6b00 0%, #ff8c42 100%);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
        }

        .userinfo-btn-primary:hover {
            background: linear-gradient(135deg, #ff8c42 0%, #ff6b00 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 0, 0.4);
            color: white;
        }

        .userinfo-btn-secondary {
            background: transparent;
            color: #ff6b00;
            border: 2px solid #ff6b00;
            padding: 0.75rem 1.5rem;
            border-radius: 25px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .userinfo-btn-secondary:hover {
            background: #ff6b00;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 107, 0, 0.3);
        }

        .profile-image {
            border: 4px solid #ff6b00;
            box-shadow: 0 0 20px rgba(255, 107, 0, 0.4);
            transition: all 0.3s ease;
        }

        .profile-image:hover {
            transform: scale(1.05);
            box-shadow: 0 0 30px rgba(255, 107, 0, 0.6);
        }

        .divider {
            border-color: rgba(255, 107, 0, 0.3);
            margin: 2rem 0;
        }

        @media (max-width: 768px) {
            .userinfo-card {
                padding: 1.5rem;
                margin: 1rem;
            }

            .info-field {
                padding: 0.75rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="userinfo-card">
                    <div class="text-center mb-4">
                        {{-- Profile Photo --}}
                        <img src="{{ $user->profile_photo_url ?? 'https://via.placeholder.com/150?text=User' }}"
                            alt="Profile Picture" class="rounded-circle profile-image"
                            style="width: 150px; height: 150px; object-fit: cover;">

                        {{-- User Name --}}
                        <h3 class="userinfo-title mt-3">{{ $user->name }}</h3>
                        <p class="text-light">{{ $user->email }}</p>
                    </div>

                    <hr class="divider">

                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="userinfo-subtitle mb-4">Account Information</h5>
                        </div>

                        {{-- Full Name --}}
                        <div class="col-md-6">
                            <div class="info-field">
                                <div class="info-label">Full Name</div>
                                <div class="info-value">{{ $user->name }}</div>
                            </div>
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <div class="info-field">
                                <div class="info-label">Email</div>
                                <div class="info-value">{{ $user->email }}</div>
                            </div>
                        </div>

                        {{-- Join Date --}}
                        <div class="col-md-6">
                            <div class="info-field">
                                <div class="info-label">Join Date</div>
                                <div class="info-value">{{ $user->created_at->format('Y-m-d') }}</div>
                            </div>
                        </div>

                        {{-- Last Update --}}
                        <div class="col-md-6">
                            <div class="info-field">
                                <div class="info-label">Last Update</div>
                                <div class="info-value">{{ $user->updated_at->format('Y-m-d H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-4">
                        {{-- Edit Profile Button --}}
                        <a href="{{ route('profile.show') }}" class="userinfo-btn-primary me-3">
                            <i class="fas fa-edit me-2"></i>Edit Profile
                        </a>

                        {{-- Back Button --}}
                        <a href="{{ url()->previous() }}" class="userinfo-btn-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

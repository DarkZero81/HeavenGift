@extends('layouts.admin')

@section('content')
    <div class="p-4">
        <div class="container-fluid">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">Settings</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item active">Settings</li>
                    </ol>
                </nav>
            </div>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row">
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="bi bi-gear me-2"></i>General Settings
                            </h6>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.settings.update') }}">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="site_name" class="form-label">Site Name</label>
                                        <input type="text" class="form-control @error('site_name') is-invalid @enderror"
                                            id="site_name" name="site_name"
                                            value="{{ old('site_name', $settings['site_name']) }}" required>
                                        @error('site_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="site_email" class="form-label">Site Email</label>
                                        <input type="email" class="form-control @error('site_email') is-invalid @enderror"
                                            id="site_email" name="site_email"
                                            value="{{ old('site_email', $settings['site_email']) }}" required>
                                        @error('site_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="currency" class="form-label">Currency</label>
                                        <select class="form-select @error('currency') is-invalid @enderror" id="currency"
                                            name="currency" required>
                                            <option value="USD"
                                                {{ old('currency', $settings['currency']) == 'USD' ? 'selected' : '' }}>USD
                                                - US Dollar</option>
                                            <option value="EUR"
                                                {{ old('currency', $settings['currency']) == 'EUR' ? 'selected' : '' }}>EUR
                                                - Euro</option>
                                            <option value="GBP"
                                                {{ old('currency', $settings['currency']) == 'GBP' ? 'selected' : '' }}>GBP
                                                - British Pound</option>
                                            <option value="JPY"
                                                {{ old('currency', $settings['currency']) == 'JPY' ? 'selected' : '' }}>JPY
                                                - Japanese Yen</option>
                                            <option value="CAD"
                                                {{ old('currency', $settings['currency']) == 'CAD' ? 'selected' : '' }}>CAD
                                                - Canadian Dollar</option>
                                            <option value="AUD"
                                                {{ old('currency', $settings['currency']) == 'AUD' ? 'selected' : '' }}>AUD
                                                - Australian Dollar</option>
                                        </select>
                                        @error('currency')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <label for="timezone" class="form-label">Timezone</label>
                                        <select class="form-select @error('timezone') is-invalid @enderror" id="timezone"
                                            name="timezone" required>
                                            <option value="UTC"
                                                {{ old('timezone', $settings['timezone']) == 'UTC' ? 'selected' : '' }}>UTC
                                            </option>
                                            <option value="America/New_York"
                                                {{ old('timezone', $settings['timezone']) == 'America/New_York' ? 'selected' : '' }}>
                                                Eastern Time</option>
                                            <option value="America/Chicago"
                                                {{ old('timezone', $settings['timezone']) == 'America/Chicago' ? 'selected' : '' }}>
                                                Central Time</option>
                                            <option value="America/Denver"
                                                {{ old('timezone', $settings['timezone']) == 'America/Denver' ? 'selected' : '' }}>
                                                Mountain Time</option>
                                            <option value="America/Los_Angeles"
                                                {{ old('timezone', $settings['timezone']) == 'America/Los_Angeles' ? 'selected' : '' }}>
                                                Pacific Time</option>
                                            <option value="Europe/London"
                                                {{ old('timezone', $settings['timezone']) == 'Europe/London' ? 'selected' : '' }}>
                                                London</option>
                                            <option value="Europe/Paris"
                                                {{ old('timezone', $settings['timezone']) == 'Europe/Paris' ? 'selected' : '' }}>
                                                Paris</option>
                                            <option value="Asia/Tokyo"
                                                {{ old('timezone', $settings['timezone']) == 'Asia/Tokyo' ? 'selected' : '' }}>
                                                Tokyo</option>
                                            <option value="Asia/Shanghai"
                                                {{ old('timezone', $settings['timezone']) == 'Asia/Shanghai' ? 'selected' : '' }}>
                                                Shanghai</option>
                                            <option value="Asia/Damascus"
                                                {{ old('timezone', $settings['timezone']) == 'Asia/Damascus' ? 'selected' : '' }}>
                                                Damascus</option>
                                        </select>
                                        @error('timezone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="maintenance_mode"
                                            name="maintenance_mode" value="1"
                                            {{ old('maintenance_mode', $settings['maintenance_mode']) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="maintenance_mode">
                                            Enable Maintenance Mode
                                        </label>
                                    </div>
                                    <div class="form-text">When enabled, the site will be unavailable to regular users.
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="bi bi-check-circle me-2"></i>Save Settings
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <!-- Quick Stats Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="bi bi-info-circle me-2"></i>System Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="p-3">
                                        <h5 class="text-primary">{{ phpversion() }}</h5>
                                        <small class="text-muted">PHP Version</small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="p-3">
                                        <h5 class="text-success">{{ config('app.version', '1.0.0') }}</h5>
                                        <small class="text-muted">App Version</small>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="text-center">
                                <p class="mb-1"><strong>Laravel Version:</strong> {{ app()->version() }}</p>
                                <p class="mb-0"><strong>Environment:</strong> {{ app()->environment() }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="bi bi-lightning me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-outline-primary btn-sm" type="button">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Clear Cache
                                </button>
                                <button class="btn btn-outline-success btn-sm" type="button">
                                    <i class="bi bi-database me-2"></i>Optimize Database
                                </button>
                                <button class="btn btn-outline-info btn-sm" type="button">
                                    <i class="bi bi-file-text me-2"></i>View Logs
                                </button>
                                <button class="btn btn-outline-warning btn-sm" type="button">
                                    <i class="bi bi-download me-2"></i>Backup System
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Security Card -->
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-white">
                                <i class="bi bi-shield-check me-2"></i>Security
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked disabled>
                                    <label class="form-check-label">
                                        Admin Authentication
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked disabled>
                                    <label class="form-check-label">
                                        CSRF Protection
                                    </label>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked disabled>
                                    <label class="form-check-label">
                                        Secure Session
                                    </label>
                                </div>
                            </div>
                            <div class="mb-0">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" checked disabled>
                                    <label class="form-check-label">
                                        Password Hashing
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .form-label {
            font-weight: 600;
            color: #2c3e50;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
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

        .card-body h1,
        .card-body h2,
        .card-body h3,
        .card-body h4,
        .card-body h5,
        .card-body h6,
        .card-body p,
        .card-body label,
        .card-body small,
        .card-body div {
            color: #2c3e50 !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            color: white;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
            transform: translateY(-1px);
            color: white;
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

        .form-text {
            color: #6c757d !important;
        }

        .invalid-feedback {
            color: #dc3545 !important;
        }

        .form-check-label {
            color: #2c3e50 !important;
        }

        .btn-outline-primary,
        .btn-outline-success,
        .btn-outline-info,
        .btn-outline-warning {
            color: #2c3e50;
            border-color: #2c3e50;
        }

        .btn-outline-primary:hover,
        .btn-outline-success:hover,
        .btn-outline-info:hover,
        .btn-outline-warning:hover {
            color: white;
        }

        .table {
            color: #2c3e50;
        }

        .alert {
            color: #2c3e50;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }
    </style>
@endsection

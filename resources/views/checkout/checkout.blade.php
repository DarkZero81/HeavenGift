@extends('layouts.app')

@section('title', 'Checkout')

@section('styles')
    <style>
        .checkout-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
        }

        .checkout-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 10px 30px rgba(33, 150, 243, 0.15);
            border: 2px solid rgba(33, 150, 243, 0.2);
            transition: all 0.4s ease;
        }

        .checkout-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(33, 150, 243, 0.2);
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 3rem;
            position: relative;
        }

        .checkout-title {
            background: linear-gradient(135deg, #2196f3 0%, #28a745 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .checkout-subtitle {
            color: #6c757d;
            font-size: 1.1rem;
        }

        .form-section {
            background: rgba(33, 150, 243, 0.02);
            border-radius: 15px;
            padding: 2rem;
            margin-bottom: 2rem;
            border: 1px solid rgba(33, 150, 243, 0.1);
        }

        .form-section-title {
            color: #2196f3;
            font-weight: 700;
            font-size: 1.3rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            color: #2196f3;
            font-weight: 600;
            margin-bottom: 0.5rem;
            display: block;
        }

        .form-control {
            border: 2px solid rgba(33, 150, 243, 0.3);
            border-radius: 12px;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
        }

        .form-control:focus {
            border-color: #2196f3;
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
            background: rgba(255, 255, 255, 1);
            color: #333;
        }

        .form-control::placeholder {
            color: #6c757d;
        }

        textarea.form-control {
            resize: vertical;
            min-height: 100px;
        }

        .btn-checkout {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            border: none;
            padding: 1rem 2.5rem;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
            transition: all 0.3s ease;
            width: 100%;
            margin-top: 1rem;
        }

        .btn-checkout:hover {
            background: linear-gradient(135deg, #20c997 0%, #28a745 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
            color: white;
        }

        .security-info {
            background: linear-gradient(135deg, rgba(33, 150, 243, 0.1) 0%, rgba(40, 167, 69, 0.1) 100%);
            border: 2px solid rgba(33, 150, 243, 0.2);
            border-radius: 15px;
            padding: 1.5rem;
            text-align: center;
            margin-top: 2rem;
        }

        .security-icon {
            color: #28a745;
            font-size: 2rem;
            margin-bottom: 1rem;
        }

        .security-title {
            color: #2196f3;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .security-text {
            color: #6c757d;
            font-size: 0.9rem;
            margin: 0;
        }

        .form-icon {
            width: 20px;
            text-align: center;
            color: #2196f3;
        }

        @media (max-width: 768px) {
            .checkout-container {
                padding: 1rem;
                margin: 1rem auto;
            }

            .checkout-card {
                padding: 1.5rem;
            }

            .checkout-title {
                font-size: 2rem;
            }

            .form-section {
                padding: 1.5rem;
            }
        }
    </style>
@endsection

@section('content')
    <div class="checkout-container">
        <div class="checkout-card">
            <div class="checkout-header">
                <h1 class="checkout-title">Secure Checkout</h1>
                <p class="checkout-subtitle">Complete your purchase with confidence</p>
            </div>

            <form method="POST" action="{{ route('checkout.store') }}">
                @csrf

                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-user form-icon"></i>
                        Customer Information
                    </h3>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_name" class="form-label">Full Name *</label>
                                <input type="text" name="customer_name" id="customer_name"
                                    value="{{ old('customer_name', auth()->user()?->name) }}"
                                    class="form-control @error('customer_name') is-invalid @enderror"
                                    placeholder="Enter your full name" required>
                                @error('customer_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_email" class="form-label">Email Address *</label>
                                <input type="email" name="customer_email" id="customer_email"
                                    value="{{ old('customer_email', auth()->user()?->email) }}"
                                    class="form-control @error('customer_email') is-invalid @enderror"
                                    placeholder="Enter your email" required>
                                @error('customer_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="customer_phone" class="form-label">Phone Number</label>
                                <input type="tel" name="customer_phone" id="customer_phone"
                                    value="{{ old('customer_phone') }}"
                                    class="form-control @error('customer_phone') is-invalid @enderror"
                                    placeholder="Enter your phone number">
                                @error('customer_phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-section">
                    <h3 class="form-section-title">
                        <i class="fas fa-map-marker-alt form-icon"></i>
                        Shipping Address
                    </h3>

                    <div class="form-group">
                        <label for="customer_address" class="form-label">Complete Address *</label>
                        <textarea name="customer_address" id="customer_address"
                            class="form-control @error('customer_address') is-invalid @enderror"
                            placeholder="Enter your complete shipping address including city, state, and postal code" rows="4" required>{{ old('customer_address') }}</textarea>
                        @error('customer_address')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn-checkout">
                    <i class="fas fa-shield-alt me-2"></i>
                    Confirm Purchase & Proceed to Payment
                </button>

                <div class="security-info">
                    <div class="security-icon">
                        <i class="fas fa-lock"></i>
                    </div>
                    <h4 class="security-title">Secure Payment</h4>
                    <p class="security-text">
                        Your payment information is encrypted and secure. We use industry-standard SSL encryption to protect
                        your data.
                    </p>
                </div>
            </form>
        </div>
    </div>
@endsection

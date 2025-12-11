<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Secure Payment - Gift Heaven</title>

    <script src="https://js.stripe.com/v3/"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Modern Color Variables */
        :root {
            --primary: #2196f3;
            --secondary: #28a745;
            --success: #20c997;
            --dark: #1a1a1a;
            --light: #ffffff;
            --gray: #f8f9fa;
            --text-dark: #333333;
            --text-light: #6c757d;
            --border: rgba(33, 150, 243, 0.2);
            --shadow: rgba(33, 150, 243, 0.15);
        }

        /* Reset and Base Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            line-height: 1.6;
        }

        /* Main Payment Container */
        .payment-container {
            max-width: 500px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 25px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
            border: 2px solid var(--border);
            transition: all 0.4s ease;
            position: relative;
            overflow: hidden;
        }

        .payment-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, var(--primary), var(--secondary), var(--primary));
            background-size: 200% 100%;
            animation: shimmer 3s ease-in-out infinite;
        }

        .payment-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.2);
        }

        /* Header Section */
        .payment-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }

        .payment-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            box-shadow: 0 10px 30px rgba(33, 150, 243, 0.3);
        }

        .payment-icon i {
            color: white;
            font-size: 2rem;
        }

        .payment-title {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 800;
            font-size: 2.2rem;
            margin-bottom: 0.5rem;
        }

        .payment-subtitle {
            color: var(--text-light);
            font-size: 1rem;
        }

        /* Form Styling */
        .payment-form {
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 600;
            color: var(--primary);
            font-size: 0.95rem;
        }

        .form-control {
            width: 100%;
            padding: 1rem;
            border: 2px solid rgba(33, 150, 243, 0.2);
            border-radius: 12px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.9);
            color: var(--text-dark);
            transition: all 0.3s ease;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
            background: rgba(255, 255, 255, 1);
        }

        .form-control::placeholder {
            color: var(--text-light);
        }

        .form-control[readonly] {
            background: rgba(248, 249, 250, 0.8);
            color: var(--text-dark);
            font-weight: 600;
        }

        /* Stripe Card Element */
        #card-element {
            padding: 1rem;
            border: 2px solid rgba(33, 150, 243, 0.2);
            border-radius: 12px;
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.3s ease;
        }

        #card-element:focus-within {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(33, 150, 243, 0.25);
        }

        /* Error Messages */
        #card-errors {
            color: #dc3545;
            margin-top: 1rem;
            font-weight: 500;
            text-align: center;
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            padding: 1rem;
            border-radius: 12px;
            display: none;
        }

        /* Payment Button */
        .submit-btn {
            background: linear-gradient(135deg, var(--secondary) 0%, var(--success) 100%);
            color: white;
            border: none;
            padding: 1.25rem 2rem;
            font-size: 1.1rem;
            font-weight: 700;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 2rem;
            width: 100%;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 5px 20px rgba(40, 167, 69, 0.3);
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover:not(:disabled) {
            background: linear-gradient(135deg, var(--success) 0%, var(--secondary) 100%);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(40, 167, 69, 0.4);
        }

        .submit-btn:disabled {
            background: #6c757d;
            cursor: not-allowed;
            opacity: 0.6;
            transform: none;
        }

        .submit-btn i {
            margin-right: 0.5rem;
        }

        /* Security Badge */
        .security-badge {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            background: rgba(40, 167, 69, 0.1);
            border: 1px solid rgba(40, 167, 69, 0.3);
            border-radius: 12px;
            padding: 1rem;
            margin-top: 1.5rem;
            color: var(--secondary);
            font-weight: 600;
            font-size: 0.9rem;
        }

        /* Loading Spinner */
        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: white;
            animation: spin 1s ease-in-out infinite;
            margin-right: 0.5rem;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% 0;
            }

            100% {
                background-position: 200% 0;
            }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 10px;
                align-items: flex-start;
                padding-top: 40px;
            }

            .payment-container {
                padding: 2rem;
                margin: 0;
            }

            .payment-title {
                font-size: 1.8rem;
            }

            .payment-icon {
                width: 60px;
                height: 60px;
            }

            .payment-icon i {
                font-size: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <div class="payment-header">
            <div class="payment-icon">
                <i class="fas fa-credit-card"></i>
            </div>
            <h1 class="payment-title">Secure Payment</h1>
            <p class="payment-subtitle">Complete your purchase safely and securely</p>
        </div>

        <form id="payment-form" class="payment-form">
            @csrf
            <input type="hidden" id="order_id" value="{{ $order->id ?? '' }}">

            <div class="form-group">
                <label for="email" class="form-label">
                    <i class="fas fa-envelope me-2"></i>Email Address
                </label>
                <input type="email" id="email" class="form-control" placeholder="Enter your email address"
                    required>
            </div>

            <div class="form-group">
                <label for="amount" class="form-label">
                    <i class="fas fa-dollar-sign me-2"></i>Amount to be Paid
                </label>
                <input type="text" id="amount" class="form-control"
                    value="${{ number_format($amount ?? 150.0, 2) }} USD" readonly>
            </div>

            <div class="form-group">
                <label for="zip_code" class="form-label">
                    <i class="fas fa-map-marker-alt me-2"></i>Postal Code
                </label>
                <input type="text" id="zip_code" class="form-control" value="123" readonly>
            </div>

            <div class="form-group">
                <label for="card-element" class="form-label">
                    <i class="fas fa-credit-card me-2"></i>Credit Card Information
                </label>
                <div id="card-element"></div>
            </div>

            <div id="card-errors" role="alert"></div>

            <button type="submit" id="submit-button" class="submit-btn">
                <i class="fas fa-lock"></i>
                Complete Payment
            </button>
        </form>

        <div class="security-badge">
            <i class="fas fa-shield-alt"></i>
            <span>Secured by Stripe • Your payment information is encrypted</span>
        </div>
    </div>

    <script>
        // Stripe Setup
        const stripe = Stripe('{{ $stripeKey ?? 'pk_test_XXXXXXXXXXXXXXXXXXXXXXXX' }}');
        const elements = stripe.elements();

        // Create Card Element with custom styling
        const card = elements.create('card', {
            style: {
                base: {
                    iconColor: '#2196f3',
                    color: '#333333',
                    fontWeight: '500',
                    fontFamily: '"Segoe UI", Tahoma, Geneva, Verdana, sans-serif',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#6c757d',
                    },
                },
                invalid: {
                    iconColor: '#dc3545',
                    color: '#dc3545',
                },
            },
            hidePostalCode: false,
        });

        // Mount the Card Element
        card.mount('#card-element');

        // Handle card errors
        card.addEventListener('change', function(event) {
            const displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.textContent = event.error.message;
                displayError.style.display = 'block';
            } else {
                displayError.textContent = '';
                displayError.style.display = 'none';
            }
        });

        // Handle form submission
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', async function(event) {
            event.preventDefault();

            const submitBtn = document.getElementById('submit-button');

            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="spinner"></div>Processing Payment...';

            try {
                // Create payment method
                const {
                    error,
                    paymentMethod
                } = await stripe.createPaymentMethod({
                    type: 'card',
                    card: card,
                    billing_details: {
                        email: document.getElementById('email').value,
                        address: {
                            postal_code: document.getElementById('zip_code').value,
                        }
                    },
                });

                if (error) {
                    // Show error
                    const displayError = document.getElementById('card-errors');
                    displayError.textContent = error.message;
                    displayError.style.display = 'block';

                    // Reset button
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-credit-card"></i>Complete Payment';
                } else {
                    // Prepare payment data
                    const paymentData = {
                        payment_method: paymentMethod.id,
                        email: document.getElementById('email').value,
                        amount: parseFloat(document.getElementById('amount').value.replace('$', '').replace(
                            ' USD', '')),
                        order_id: document.getElementById('order_id').value,
                        zip_code: document.getElementById('zip_code').value,
                    };

                    // Send payment data to server
                    const response = await fetch('/pay', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        },
                        body: JSON.stringify(paymentData)
                    });

                    const result = await response.json();

                    if (result.status === 'succeeded') {
                        window.location.href = result.url;
                    } else if (result.status === 'requires_action') {
                        const {
                            error
                        } = await stripe.confirmCardPayment(result.client_secret);
                        if (error) {
                            throw new Error(error.message);
                        } else {
                            window.location.href = result.url;
                        }
                    } else {
                        throw new Error(result.error || 'Payment failed');
                    }
                }
            } catch (err) {
                console.error('Payment error:', err);

                // Show error message
                const displayError = document.getElementById('card-errors');
                displayError.textContent = 'An unexpected error occurred. Please try again.';
                displayError.style.display = 'block';

                // Reset button
                submitBtn.disabled = false;
                submitBtn.innerHTML = '<i class="fas fa-credit-card"></i>Complete Payment';
            }
        });
    </script>
</body>

</html>

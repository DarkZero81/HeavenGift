<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .success-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        .success-icon {
            width: 80px;
            height: 80px;
            background: #28a745;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .success-icon::before {
            content: '✓';
            color: white;
            font-size: 40px;
            font-weight: bold;
        }

        .success-title {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .success-message {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            line-height: 1.5;
        }

        .payment-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
            text-align: left;
        }

        .payment-details h3 {
            color: #333;
            margin-bottom: 15px;
            text-align: center;
            font-size: 18px;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e1e5e9;
        }

        .detail-row:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .detail-label {
            color: #666;
            font-weight: 500;
        }

        .detail-value {
            color: #333;
            font-weight: 600;
        }

        .redirect-info {
            background: #e3f2fd;
            border: 1px solid #2196f3;
            border-radius: 8px;
            padding: 15px;
            margin: 25px 0;
        }

        .redirect-info h4 {
            color: #1976d2;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .redirect-info p {
            color: #666;
            font-size: 14px;
        }

        .countdown {
            font-size: 24px;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }

        .home-button {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: transform 0.2s;
            margin-top: 15px;
        }

        .home-button:hover {
            transform: translateY(-2px);
        }

        .status-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-success {
            background: #d4edda;
            color: #155724;
        }
    </style>
</head>

<body>
    <div class="success-container">
        <div class="success-icon"></div>

        <h1 class="success-title">Payment Successful!</h1>
        <p class="success-message">
            Your payment has been processed successfully. Thank you for your purchase!
        </p>

        <div class="payment-details">
            <h3>Payment Information</h3>

            <div class="detail-row">
                <span class="detail-label">Transaction ID:</span>
                <span class="detail-value">{{ $payment->payment_intent_id ?? 'N/A' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Amount:</span>
                <span class="detail-value">${{ number_format($payment->amount ?? 0, 2) }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Currency:</span>
                <span class="detail-value">{{ strtoupper($payment->currency ?? 'USD') }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Email:</span>
                <span class="detail-value">{{ $payment->email ?? 'N/A' }}</span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Status:</span>
                <span class="detail-value">
                    <span class="status-badge status-success">
                        {{ ucfirst($payment->status ?? 'completed') }}
                    </span>
                </span>
            </div>

            <div class="detail-row">
                <span class="detail-label">Date:</span>
                <span class="detail-value">{{ now()->format('M j, Y g:i A') }}</span>
            </div>
        </div>

        <div class="redirect-info">
            <h4>Redirecting to Home Page</h4>
            <p>You will be automatically redirected to the home page in <span class="countdown" id="countdown">10</span>
                seconds.</p>
        </div>

        <a href="{{ route('home') }}" class="home-button">
            Return to Home Page
        </a>
    </div>

    <script>
        // Countdown timer
        let timeLeft = 10;
        const countdownElement = document.getElementById('countdown');

        const timer = setInterval(() => {
            timeLeft--;
            countdownElement.textContent = timeLeft;

            if (timeLeft <= 0) {
                clearInterval(timer);
                window.location.href = '{{ route('home') }}';
            }
        }, 1000);

        // Optional: Allow user to cancel auto-redirect by clicking anywhere
        document.addEventListener('click', function() {
            clearInterval(timer);
            document.querySelector('.redirect-info p').innerHTML =
                'Click the button above or wait to be redirected to the home page.';
        });
    </script>
</body>

</html>

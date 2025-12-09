<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>

    <script src="https://js.stripe.com/v3/"></script>
    <style>
        /* Color variable definitions from home.css */
        :root {
            --primary: #FF6B00;
            /* Orange */
            --secondary: #50247A;
            /* Dark Purple */
            --dark: #0F061E;
            /* Very Dark */
            --light: #F8F9FA;
            /* Light */
            --accent: #FFD200;
            /* Golden Yellow */
        }

        /* Background and General Layout */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: var(--light);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0;
            padding: 20px;
        }

        /* Main Payment Container (Card) */
        .payment-container {
            max-width: 450px;
            width: 100%;
            background-color: var(--dark);
            padding: 2.5rem;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.5);
            border: 1px solid var(--accent);
            /* Accent colored border */
        }

        /* Title */
        h2 {
            text-align: center;
            color: var(--accent);
            margin-bottom: 1.5rem;
            font-weight: 700;
            border-bottom: 2px solid rgba(255, 210, 0, 0.3);
            padding-bottom: 0.5rem;
        }

        /* Form Groups */
        .form-group {
            margin-bottom: 1.25rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--light);
        }

        /* Input Fields */
        input {
            padding: 0.75rem;
            width: 100%;
            border: 1px solid var(--secondary);
            border-radius: 8px;
            font-size: 1rem;
            box-sizing: border-box;
            background-color: #1a0f2b;
            /* Darker background color for field */
            color: var(--light);
        }

        input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(255, 210, 0, 0.3);
        }

        /* Stripe Card Element - The background changed to look clearer */
        #card-element {
            padding: 0.75rem;
            border: 1px solid var(--accent);
            /* Accent colored border */
            border-radius: 8px;
            background-color: var(--secondary);
            /* Slightly lighter dark purple color */
            /* Ensure element visibility */
        }

        /* Error Messages */
        #card-errors {
            color: var(--accent);
            /* Use accent color for errors */
            margin-top: 1rem;
            font-weight: 500;
            text-align: center;
            background-color: #7a2424;
            /* Dark red background */
            border: 1px solid #ff6b6b;
            padding: 0.75rem;
            border-radius: 8px;
            display: none;
            /* Displayed via JavaScript */
        }

        /* Payment Button */
        .submit-btn {
            background-color: var(--primary);
            /* Attractive Orange */
            color: var(--dark);
            /* Dark text for contrast */
            border: none;
            padding: 1rem 1.5rem;
            font-size: 1.1rem;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s;
            margin-top: 2rem;
            width: 100%;
        }

        .submit-btn:hover:not(:disabled) {
            background-color: var(--accent);
            /* Button color changes on hover */
            transform: translateY(-3px);
            color: var(--dark);
        }

        .submit-btn:disabled {
            background-color: #ff9d5c;
            cursor: not-allowed;
            opacity: 0.6;
            transform: none;
        }
    </style>
</head>

<body>
    <div class="payment-container">
        <h2>Complete Payment</h2>

        <form id="payment-form">
            <div class="form-group">
                <label for="email">E-mail </label>
                <input type="email" id="email" placeholder="Enter Your Email" required>
            </div>

            <div class="form-group">
                <label for="amount">Amount to be Paid</label>
                <input type="text" id="amount" value="150.00 SAR" readonly>
            </div>

            <div class="form-group">
                <label for="card-element"> Credit Card Info</label>
                <div id="card-element">
                </div>
            </div>

            <div id="card-errors" role="alert"></div>

            @include('partials.paybutton')

        </form>
    </div>


    <script>
        // Stripe Setup (This part is required to fully experience the interface)
        const stripe = Stripe(
            '{{ $stripeKey ?? 'pk_test_XXXXXXXXXXXXXXXXXXXXXXXX' }}'); // Using the key from controller or fallback
        const elements = stripe.elements();

        // Create Card Element
        const card = elements.create('card', {
            style: {
                base: {
                    iconColor: 'var(--accent)',
                    color: 'var(--light)',
                    fontWeight: '500',
                    fontFamily: 'Segoe UI, Tahoma, Geneva, Verdana, sans-serif',
                    fontSize: '16px',
                    '::placeholder': {
                        color: '#aab7c4',
                    },
                },
                invalid: {
                    iconColor: '#FF6B6B',
                    color: '#FF6B6B',
                },
            }
        });

        // Mount the Card Element to the UI
        card.mount('#card-element');

        // Handle immediate errors in card fields
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

        // Handle Form Submission
        const form = document.getElementById('payment-form');
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const submitBtn = document.getElementById('submit-button');

            // Disable button and show loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<div class="spinner">Processing...</div>';

            // Processing simulation: Redirect to success page after 2 seconds
            setTimeout(() => {
                // Simulate success and redirect to the success page
                window.location.href = '/payment-success'; // Use your actual Laravel route here
            }, 2000);
        });
    </script>
</body>

</html>

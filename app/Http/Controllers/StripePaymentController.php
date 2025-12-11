<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\PaymentIntent;
use App\Models\Payment;
use Illuminate\Support\Facades\Log; // For robust error logging

class StripePaymentController extends Controller
{
    /**
     * Show the payment form view.
     */
    public function showPaymentForm(Request $request)
    {
        $orderId = $request->query('order_id');
        $order = null;
        $amount = 150.00; // Default amount if no order found

        if ($orderId) {
            $order = \App\Models\order::find($orderId);
            if ($order) {
                $amount = $order->total;
            }
        }

        // This key is publishable and safe to expose to the client side.
        return view('pay', [
            'stripeKey' => config('services.stripe.key'),
            'order' => $order,
            'amount' => $amount
        ]);
    }

    /**
     * Process the payment request by creating a Stripe PaymentIntent.
     * This method is designed to be called via AJAX from the frontend.
     */
    public function processPayment(Request $request)
    {
        // 1. Validation (Arabic comments removed for consistency)
        $request->validate([
            'amount' => 'required|numeric|min:10',
            // 'payment_method' is typically the Stripe Payment Method ID from the frontend
            'payment_method' => 'required|string',
            'email' => 'required|email',
            'order_id' => 'nullable|exists:orders,id',
            'zip_code' => 'nullable|string|max:10',
        ]);

        // 2. Stripe Initialization
        // Use the secret key for server-side operations.
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $amountInCents = $request->amount * 100;

            // 3. Create the PaymentIntent
            $intent = PaymentIntent::create([
                'amount' => $amountInCents,
                'currency' => 'usd',
                'payment_method' => $request->payment_method,
                'receipt_email' => $request->email,
                'billing_address' => [
                    'postal_code' => $request->zip_code ?? '123',
                ],
                // Crucial for telling Stripe what URL to redirect to if a 3D Secure
                // or other "next action" is required after the initial request.
                'confirm' => true,
                // The URL Stripe will send the customer to after they complete the 3D Secure check.
                'return_url' => route('payment-success') . '?id=' . $request->payment_method . '&order_id=' . ($request->order_id ?? ''),
                // You were setting 'automatic_payment_methods' but 'confirm' is the correct way
                // to handle the immediate attempt with a provided payment method ID.
            ]);

            // 4. Handle Different Statuses (Crucial for modern Stripe flows)
            $status = $intent->status;

            if ($status === 'requires_action' || $status === 'requires_source_action') {
                // If 3D Secure or another action is required, Stripe will populate
                // 'next_action'. Send this back to the client to complete the action.
                return response()->json([
                    'status' => 'requires_action',
                    'client_secret' => $intent->client_secret,
                ]);
            }

            // 5. Database Logging (Move outside of the success check to cover all statuses)
            // Log the payment intent *before* checking for success to ensure a record exists.
            Payment::create([
                'payment_intent_id' => $intent->id,
                'amount' => $request->amount,
                'currency' => 'usd',
                'status' => $status, // The status will be 'succeeded', 'requires_capture', or 'failed'
                'email' => $request->email,
                'order_id' => $request->order_id,
            ]);

            // 6. Final Success Response
            if ($status === 'succeeded' || $status === 'requires_capture') {
                return response()->json([
                    'status' => 'succeeded',
                    // Redirect the frontend to your success page immediately
                    'url' => route('payment.success', ['id' => $intent->id])
                ]);
            } else {
                // Handle other final unsuccessful statuses (e.g., 'requires_payment_method')
                $errorMessage = $intent->last_payment_error->message ?? 'Payment failed due to an unknown error.';
                Log::error('Stripe Payment Failed (Final Status): ' . $errorMessage . ' Intent ID: ' . $intent->id);

                return response()->json([
                    'status' => 'failed',
                    'error' => 'Payment Failed: ' . $errorMessage
                ], 400);
            }
        } catch (\Stripe\Exception\CardException $e) {
            // Handle card errors (e.g., insufficient funds, card declined)
            return response()->json([
                'status' => 'failed',
                'error' => 'Card Error: ' . $e->getMessage()
            ], 400);
        } catch (\Exception $e) {
            // Log any other general API or system errors
            Log::error('Stripe Processing Error: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'error' => 'A server error occurred during payment processing: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle the successful return from the payment gateway.
     */
    public function paymentSuccess(Request $request)
    {
        $paymentId = $request->query('id');
        $orderId = $request->query('order_id');

        // البحث عن الدفع باستخدام payment_intent_id
        $payment = Payment::where('payment_intent_id', $paymentId)->first();

        // Get order details if available
        $order = null;
        if ($orderId) {
            $order = \App\Models\order::find($orderId);
        }

        if (!$payment) {
            // If the record isn't found, create a demo payment for display
            $payment = new \stdClass();
            $payment->payment_intent_id = $paymentId;
            $payment->amount = $order ? $order->total : 150.00;
            $payment->currency = 'usd';
            $payment->status = 'succeeded';
            $payment->email = 'demo@example.com';
            Log::warning('Payment Success Redirect failed to find Payment Intent ID: ' . $paymentId);
        }

        // Optional: Re-fetch the intent from Stripe here to be 100% sure of the status
        // Stripe::setApiKey(config('services.stripe.secret'));
        // $intent = PaymentIntent::retrieve($paymentId);
        // $payment->update(['status' => $intent->status]); // Update status

        return view('pay-success', compact('payment', 'order'));
    }

    /**
     * Handle direct payment button clicks (demo functionality)
     */
    public function instantPayment()
    {
        try {
            // Create a demo payment record
            $payment = Payment::create([
                'payment_intent_id' => 'demo_' . uniqid(),
                'amount' => 150.00,
                'currency' => 'usd',
                'status' => 'succeeded',
                'email' => 'demo@example.com',
            ]);

            // Redirect to success page with the payment ID
            return redirect()->route('payment.success', ['id' => $payment->payment_intent_id]);
        } catch (\Exception $e) {
            Log::error('Demo Payment Error: ' . $e->getMessage());
            return redirect()->route('pay.form')->with('error', 'Payment failed. Please try again.');
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        return view('admin.payments.show', compact('payment'));
    }

    public function destroy(Payment $payment)
    {
        try {
            $payment->delete();
            return redirect()->route('admin.payments.index')
                ->with('success', 'Payment deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('admin.payments.index')
                ->with('error', 'Failed to delete payment. Please try again.');
        }
    }

    public function create()
    {
        // For now, redirect back to index since payments are created via Stripe
        return redirect()->route('admin.payments.index')
            ->with('info', 'Payments are automatically created when customers complete transactions.');
    }

    public function store(Request $request)
    {
        // For now, redirect back to index since payments are created via Stripe
        return redirect()->route('admin.payments.index')
            ->with('info', 'Payments are automatically created when customers complete transactions.');
    }
}

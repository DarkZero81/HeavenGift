<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Basic analytics data
        $stats = [
            'total_users' => User::count(),
            'total_orders' => Order::count(),
            'total_revenue' => Payment::where('status', 'completed')->sum('amount'),
            'total_products' => Product::count(),
            'recent_orders' => Order::with('user')->latest()->take(5)->get(),
            'top_products' => Product::withCount('orderItems')
                ->orderBy('order_items_count', 'desc')
                ->take(5)
                ->get(),
            'monthly_sales' => Payment::where('status', 'completed')
                ->whereMonth('created_at', now()->month)
                ->sum('amount'),
        ];

        // Sales chart data (last 7 days)
        $salesChart = Payment::where('status', 'completed')
            ->whereDate('created_at', '>=', now()->subDays(7))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(amount) as total'))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.analytics.index', compact('stats', 'salesChart'));
    }
}

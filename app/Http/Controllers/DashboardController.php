<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pending_orders' => ServiceOrder::where('status', 'pending')->count(),
            'in_progress_orders' => ServiceOrder::where('status', 'in_progress')->count(),
            'completed_orders' => ServiceOrder::where('status', 'completed')->count(),
            'total_sales_today' => Sale::whereDate('created_at', today())->sum('total'),
            'low_stock_products' => Product::where('stock', '<', 5)->count(),
        ];

        $recentOrders = ServiceOrder::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $recentSales = Sale::with('customer')
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentOrders', 'recentSales'));
    }
}

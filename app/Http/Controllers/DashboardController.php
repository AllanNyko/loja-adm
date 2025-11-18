<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Calcular média mensal e comparação
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        $totalRevenueYearToDate = 0;
        for ($month = 1; $month <= $currentMonth; $month++) {
            $sales = Sale::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total');
            
            $orders = ServiceOrder::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where('status', 'completed')
                ->sum('price');
            
            $totalRevenueYearToDate += ($sales + $orders);
        }
        
        $monthlyAverage = $currentMonth > 0 ? $totalRevenueYearToDate / $currentMonth : 0;
        
        // Faturamento do mês atual
        $currentMonthRevenue = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total') +
            ServiceOrder::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->sum('price');
        
        $differenceFromAverage = $currentMonthRevenue - $monthlyAverage;
        
        // Estatísticas gerais
        $stats = [
            'pending_orders' => ServiceOrder::where('status', 'pending')->count(),
            'in_progress_orders' => ServiceOrder::where('status', 'in_progress')->count(),
            'completed_orders' => ServiceOrder::where('status', 'completed')->count(),
            'total_sales_today' => Sale::whereDate('created_at', today())->sum('total') + 
                                   ServiceOrder::whereDate('created_at', today())
                                   ->where('status', 'completed')
                                   ->sum('price'),
            'total_sales_month' => $currentMonthRevenue,
            'low_stock_products' => Product::where('stock', '<', 5)->count(),
            'monthly_average' => $monthlyAverage,
            'difference_from_average' => $differenceFromAverage,
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

    private function getChartData()
    {
        $days = [];
        $salesData = [];
        $ordersData = [];

        // Gerar últimos 7 dias
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $days[] = $date->format('d/m');

            // Total de vendas do dia
            $salesData[] = Sale::whereDate('created_at', $date)->sum('total');

            // Total de ordens de serviço do dia (pela data de criação)
            $ordersData[] = ServiceOrder::whereDate('created_at', $date)->sum('price');
        }

        return [
            'labels' => $days,
            'sales' => $salesData,
            'orders' => $ordersData,
        ];
    }
}

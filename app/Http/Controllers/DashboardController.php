<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Calcular média mensal e comparação (considerando despesas)
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        $totalNetRevenueYearToDate = 0;
        for ($month = 1; $month <= $currentMonth; $month++) {
            $sales = Sale::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total');
            
            // Para OS concluídas, calcular lucro real: final_cost - parts_cost - extra_cost_value
            $orders = ServiceOrder::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where('status', 'completed')
                ->get()
                ->sum(function($order) {
                    $finalCost = $order->final_cost ?? $order->price ?? 0;
                    $partsCost = $order->parts_cost ?? 0;
                    $extraCost = $order->extra_cost_value ?? 0;
                    return $finalCost - $partsCost - $extraCost;
                });
            
            $expenses = Expense::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where('status', 'paid')
                ->sum('amount');
            
            $totalNetRevenueYearToDate += (($sales + $orders) - $expenses);
        }
        
        $monthlyAverage = $currentMonth > 0 ? $totalNetRevenueYearToDate / $currentMonth : 0;
        
        // Faturamento bruto do mês atual
        $currentMonthSales = Sale::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('total');
            
        // Lucro real das OS (final_cost - parts_cost - extra_cost)
        $currentMonthOrders = ServiceOrder::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'completed')
            ->get()
            ->sum(function($order) {
                $finalCost = $order->final_cost ?? $order->price ?? 0;
                $partsCost = $order->parts_cost ?? 0;
                $extraCost = $order->extra_cost_value ?? 0;
                return $finalCost - $partsCost - $extraCost;
            });
        
        // Despesas do mês atual
        $currentMonthExpenses = Expense::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->where('status', 'paid')
            ->sum('amount');
        
        // Faturamento líquido do mês (lucro bruto - despesas)
        $currentMonthNetRevenue = ($currentMonthSales + $currentMonthOrders) - $currentMonthExpenses;
        
        $differenceFromAverage = $currentMonthNetRevenue - $monthlyAverage;
        
        // Faturamento do dia (lucro bruto - despesas do dia)
        $todaySales = Sale::whereDate('created_at', today())->sum('total');
        
        $todayOrders = ServiceOrder::whereDate('created_at', today())
            ->where('status', 'completed')
            ->get()
            ->sum(function($order) {
                $finalCost = $order->final_cost ?? $order->price ?? 0;
                $partsCost = $order->parts_cost ?? 0;
                $extraCost = $order->extra_cost_value ?? 0;
                return $finalCost - $partsCost - $extraCost;
            });
            
        $todayExpenses = Expense::whereDate('created_at', today())
            ->where('status', 'paid')
            ->sum('amount');
        
        $todayNetRevenue = ($todaySales + $todayOrders) - $todayExpenses;
        
        // Estatísticas gerais
        $stats = [
            'pending_orders' => ServiceOrder::where('status', 'pending')->count(),
            'in_progress_orders' => ServiceOrder::where('status', 'in_progress')->count(),
            'completed_orders' => ServiceOrder::where('status', 'completed')->count(),
            'total_sales_today' => $todayNetRevenue,
            'total_sales_month' => $currentMonthNetRevenue,
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

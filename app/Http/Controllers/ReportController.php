<?php

namespace App\Http\Controllers;

use App\Models\ServiceOrder;
use App\Models\Sale;
use App\Models\Expense;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index()
    {
        // Dados para gráfico - últimos 7 dias
        $last7Days = $this->getLast7DaysData();
        
        // Dados para gráfico - últimos 6 meses
        $last6Months = $this->getLast6MonthsData();
        
        // Resumo do mês atual
        $currentMonthSummary = $this->getCurrentMonthSummary();

        // Dados para gráfico de linhas - Janeiro até mês atual
        $monthlyTrend = $this->getMonthlyTrendData();

        return view('reports.index', compact('last7Days', 'last6Months', 'currentMonthSummary', 'monthlyTrend'));
    }

    public function exportPdf(Request $request)
    {
        $month = $request->get('month', now()->format('Y-m'));
        $date = Carbon::createFromFormat('Y-m', $month);
        
        // Dados diários do mês
        $dailyData = $this->getMonthlyDailyData($date);
        
        // Dados dos últimos 6 meses
        $last6Months = $this->getLast6MonthsData();
        
        // Total do mês
        $sales = Sale::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->sum('total');
            
        $orders = ServiceOrder::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->sum('price');
            
        $expenses = Expense::whereYear('created_at', $date->year)
            ->whereMonth('created_at', $date->month)
            ->where('status', 'paid')
            ->sum('amount');
        
        $monthTotal = [
            'sales' => $sales,
            'orders' => $orders,
            'expenses' => $expenses,
            'revenue' => $sales + $orders,
            'net_revenue' => ($sales + $orders) - $expenses,
        ];
        $monthTotal['total'] = $monthTotal['revenue'];

        $pdf = Pdf::loadView('reports.pdf', [
            'month' => $date->format('m/Y'),
            'dailyData' => $dailyData,
            'last6Months' => $last6Months,
            'monthTotal' => $monthTotal,
        ]);

        return $pdf->download('relatorio-' . $date->format('Y-m') . '.pdf');
    }

    private function getLast7DaysData()
    {
        $days = [];
        $salesData = [];
        $ordersData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $days[] = $date->format('d/m');

            $salesData[] = Sale::whereDate('created_at', $date)->sum('total');
            $ordersData[] = ServiceOrder::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('price');
        }

        return [
            'labels' => $days,
            'sales' => $salesData,
            'orders' => $ordersData,
        ];
    }

    private function getLast6MonthsData()
    {
        $months = [];
        $salesData = [];
        $ordersData = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M/y');

            $salesData[] = Sale::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->sum('total');
            
            $ordersData[] = ServiceOrder::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)
                ->where('status', 'completed')
                ->sum('price');
        }

        return [
            'labels' => $months,
            'sales' => $salesData,
            'orders' => $ordersData,
        ];
    }

    private function getCurrentMonthSummary()
    {
        $now = Carbon::now();
        
        $sales = Sale::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->sum('total');
            
        $orders = ServiceOrder::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->where('status', 'completed')
            ->sum('price');
            
        $expenses = Expense::whereYear('created_at', $now->year)
            ->whereMonth('created_at', $now->month)
            ->where('status', 'paid')
            ->sum('amount');
        
        return [
            'month' => $now->format('F/Y'),
            'sales' => $sales,
            'orders' => $orders,
            'expenses' => $expenses,
            'revenue' => $sales + $orders,
            'net_revenue' => ($sales + $orders) - $expenses,
        ];
    }

    private function getMonthlyDailyData($date)
    {
        $daysInMonth = $date->daysInMonth;
        $dailyData = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $currentDate = Carbon::create($date->year, $date->month, $day);
            
            $sales = Sale::whereDate('created_at', $currentDate)->sum('total');
            $orders = ServiceOrder::whereDate('created_at', $currentDate)
                ->where('status', 'completed')
                ->sum('price');
            
            $dailyData[] = [
                'day' => $day,
                'date' => $currentDate->format('d/m/Y'),
                'sales' => $sales,
                'orders' => $orders,
                'total' => $sales + $orders,
            ];
        }

        return $dailyData;
    }

    private function getMonthlyTrendData()
    {
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        
        $months = [];
        $monthlyRevenue = [];
        $totalRevenue = 0;
        
        // Calcular faturamento de janeiro até mês atual
        for ($month = 1; $month <= $currentMonth; $month++) {
            $date = Carbon::create($currentYear, $month, 1);
            $months[] = $date->format('M/y');
            
            $sales = Sale::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->sum('total');
            
            $orders = ServiceOrder::whereYear('created_at', $currentYear)
                ->whereMonth('created_at', $month)
                ->where('status', 'completed')
                ->sum('price');
            
            $revenue = $sales + $orders;
            $monthlyRevenue[] = $revenue;
            $totalRevenue += $revenue;
        }
        
        // Calcular média
        $average = $currentMonth > 0 ? $totalRevenue / $currentMonth : 0;
        $averageLine = array_fill(0, $currentMonth, $average);
        
        return [
            'labels' => $months,
            'revenue' => $monthlyRevenue,
            'average' => $averageLine,
            'averageValue' => $average,
            'totalRevenue' => $totalRevenue,
            'monthCount' => $currentMonth,
        ];
    }
}


<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;

// Rotas públicas - redireciona para login
Route::get('/', function () {
    return redirect()->route('login');
});

// Rota pública para rastreamento de Ordem de Serviço
Route::get('/os/{orderNumber}', [ServiceOrderController::class, 'track'])->name('service-orders.track');

// Rotas protegidas por autenticação
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export-pdf', [ReportController::class, 'exportPdf'])->name('reports.export-pdf');

    // Service Orders
    Route::resource('service-orders', ServiceOrderController::class);
    Route::post('service-orders/{serviceOrder}/status', [ServiceOrderController::class, 'updateStatus'])
        ->name('service-orders.update-status');
    Route::get('service-orders/{serviceOrder}/pdf', [ServiceOrderController::class, 'exportPdf'])
        ->name('service-orders.export-pdf');

    // Sales
    Route::resource('sales', SaleController::class)->except(['edit', 'update']);
    Route::get('sales/{sale}/pdf', [SaleController::class, 'exportPdf'])
        ->name('sales.export-pdf');

    // Products
    Route::resource('products', ProductController::class);

    // Customers
    Route::resource('customers', CustomerController::class);

    // Expenses
    Route::resource('expenses', ExpenseController::class);
    Route::post('expenses/{expense}/mark-as-paid', [ExpenseController::class, 'markAsPaid'])
        ->name('expenses.mark-as-paid');
});

require __DIR__.'/auth.php';

<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReportController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

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

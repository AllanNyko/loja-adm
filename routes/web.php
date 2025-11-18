<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ServiceOrderController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Service Orders
Route::resource('service-orders', ServiceOrderController::class);
Route::post('service-orders/{serviceOrder}/status', [ServiceOrderController::class, 'updateStatus'])
    ->name('service-orders.update-status');

// Sales
Route::resource('sales', SaleController::class)->except(['edit', 'update']);

// Products
Route::resource('products', ProductController::class);

// Customers
Route::resource('customers', CustomerController::class);

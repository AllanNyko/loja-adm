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

// Rota pública para download de PDF via hash
Route::get('/os/download/{hash}', [ServiceOrderController::class, 'downloadPdf'])->name('service-orders.download-pdf');

// Rota pública para galeria de fotos
Route::get('/os/photos/{hash}', [ServiceOrderController::class, 'showPhotosGallery'])->name('service-orders.photos-gallery');

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
    Route::post('service-orders/{serviceOrder}/cancel', [ServiceOrderController::class, 'cancelOrder'])
        ->name('service-orders.cancel');
    Route::get('service-orders/{serviceOrder}/pdf', [ServiceOrderController::class, 'exportPdf'])
        ->name('service-orders.export-pdf');
    Route::get('service-orders/{serviceOrder}/client-pdf', [ServiceOrderController::class, 'exportClientPdf'])
        ->name('service-orders.export-client-pdf');
    Route::get('service-orders/{serviceOrder}/whatsapp', [ServiceOrderController::class, 'sendToWhatsApp'])
        ->name('service-orders.whatsapp');
    Route::get('/api/devices/search', [ServiceOrderController::class, 'searchDevices'])
        ->name('api.devices.search');
    Route::get('/api/devices/{manufacturer}/models', [ServiceOrderController::class, 'getManufacturerModels'])
        ->name('api.devices.models');

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

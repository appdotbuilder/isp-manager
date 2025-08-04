<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ServicePackageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Main ISP dashboard on home page
Route::get('/', [DashboardController::class, 'index'])->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Customer management routes
    Route::resource('customers', CustomerController::class);
    
    // Service package management routes
    Route::resource('service-packages', ServicePackageController::class);
    
    // Invoice management routes
    Route::resource('invoices', InvoiceController::class);
    
    // Payment management routes
    Route::resource('payments', PaymentController::class);
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';

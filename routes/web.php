<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BulkOrderController;
use App\Http\Controllers\Admin\PricingTierController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Auth\LoginController;

Route::get('/', function () {
    if (auth()->check() && auth()->user()->hasAdminAccess()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('login');
});

// Authentication Routes (Public)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    
    Route::get('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [\App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register.submit');
    Route::get('/register/success', function () {
        return view('auth.register-success');
    })->name('register.success');
});

// Logout Route (Authenticated users only)
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});

// Admin Routes (Protected - Only super_admin and admin can access)
Route::middleware(['auth', 'role:super_admin,admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Bulk Orders
    Route::get('/bulk-orders', [BulkOrderController::class, 'index'])->name('bulk-orders.index');
    Route::get('/bulk-orders/create', [BulkOrderController::class, 'create'])->name('bulk-orders.create');
    
    // Pricing Tiers
    Route::get('/pricing-tiers', [PricingTierController::class, 'index'])->name('pricing-tiers.index');
    Route::get('/pricing-tiers/create', [PricingTierController::class, 'create'])->name('pricing-tiers.create');
    
    // Customers
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/{id}', [CustomerController::class, 'show'])->name('customers.show');
});

<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome');
})->name('home');

// Client Authentication Routes
Route::middleware('guest')->group(function () {
    // Login
    Route::get('/login', [\App\Http\Controllers\Client\AuthController::class, 'showLogin'])->name('client.login');
    Route::post('/login', [\App\Http\Controllers\Client\AuthController::class, 'login']);

    // Register
    Route::get('/register', [\App\Http\Controllers\Client\AuthController::class, 'showRegister'])->name('client.register');
    Route::post('/register', [\App\Http\Controllers\Client\AuthController::class, 'register']);

    // Forgot Password
    Route::get('/forgot-password', [\App\Http\Controllers\Client\PasswordResetController::class, 'showForgotPassword'])->name('client.password.request');
    Route::post('/forgot-password', [\App\Http\Controllers\Client\PasswordResetController::class, 'forgotPassword'])->name('client.password.email');

    // Reset Password
    Route::get('/reset-password/{token}', [\App\Http\Controllers\Client\PasswordResetController::class, 'showResetPassword'])->name('client.password.reset');
    Route::post('/reset-password', [\App\Http\Controllers\Client\PasswordResetController::class, 'resetPassword'])->name('client.password.update');
});

// Client Logout
Route::post('/logout', [\App\Http\Controllers\Client\AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('client.logout');

// Client Protected Routes
Route::middleware(['auth'])->group(function () {
    // Shop
    Route::get('/shop', [\App\Http\Controllers\Client\ShopController::class, 'index'])->name('client.shop');

    // Cart
    Route::get('/cart', [\App\Http\Controllers\Client\CartController::class, 'index'])->name('client.cart.index');
    Route::post('/cart/add', [\App\Http\Controllers\Client\CartController::class, 'add'])->name('client.cart.add');
    Route::patch('/cart/{cartItem}', [\App\Http\Controllers\Client\CartController::class, 'update'])->name('client.cart.update');
    Route::delete('/cart/{cartItem}', [\App\Http\Controllers\Client\CartController::class, 'remove'])->name('client.cart.remove');

    // Checkout
    Route::get('/checkout', [\App\Http\Controllers\Client\CheckoutController::class, 'index'])->name('client.checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\Client\CheckoutController::class, 'store'])->name('client.checkout.store');

    // Orders
    Route::get('/orders/{order}', [\App\Http\Controllers\Client\OrderController::class, 'show'])->name('client.orders.show');
});

// Admin Routes - All admin routes are prefixed with /admin
Route::prefix('admin')
    ->middleware(['auth', 'verified', 'admin'])
    ->name('admin.')
    ->group(function () {
        // Dashboard
        Route::get('dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');

        // User Management
        Route::resource('users', \App\Http\Controllers\Admin\UserController::class)->only(['index', 'store', 'update', 'destroy']);

        // Product Management
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class)->only(['index', 'store', 'update', 'destroy']);

        // Order Management
        Route::get('orders', [\App\Http\Controllers\Admin\OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/{order}', [\App\Http\Controllers\Admin\OrderController::class, 'show'])->name('orders.show');
        Route::patch('orders/{order}/status', [\App\Http\Controllers\Admin\OrderController::class, 'updateStatus'])->name('orders.updateStatus');

        // Settings Routes
        require __DIR__ . '/settings.php';
    });

// Redirect /dashboard to /admin/dashboard for backwards compatibility
Route::redirect('/dashboard', '/admin/dashboard')->name('dashboard');

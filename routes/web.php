<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canRegister' => false, // Registration disabled for admin-only auth
    ]);
})->name('home');

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

        // Settings Routes
        require __DIR__ . '/settings.php';
    });

// Redirect /dashboard to /admin/dashboard for backwards compatibility
Route::redirect('/dashboard', '/admin/dashboard')->name('dashboard');

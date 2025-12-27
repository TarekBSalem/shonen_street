<?php

use App\Http\Controllers\Settings\PasswordController;
use App\Http\Controllers\Settings\ProfileController;
use App\Http\Controllers\Settings\TwoFactorAuthenticationController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Admin Settings - Routes are prefixed with /admin and protected by admin middleware
Route::redirect('settings', 'settings/profile');

Route::get('settings/profile', [ProfileController::class, 'edit'])->name('settings.profile.edit');
Route::patch('settings/profile', [ProfileController::class, 'update'])->name('settings.profile.update');
Route::delete('settings/profile', [ProfileController::class, 'destroy'])->name('settings.profile.destroy');

Route::get('settings/password', [PasswordController::class, 'edit'])->name('settings.password.edit');

Route::put('settings/password', [PasswordController::class, 'update'])
    ->middleware('throttle:6,1')
    ->name('settings.password.update');

Route::get('settings/appearance', function () {
    return Inertia::render('settings/Appearance');
})->name('settings.appearance.edit');

Route::get('settings/two-factor', [TwoFactorAuthenticationController::class, 'show'])->name('settings.two-factor.show');

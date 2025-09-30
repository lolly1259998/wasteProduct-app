<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Product Routes
    Route::resource('products', ProductController::class);

    // Donation Routes
    Route::resource('donations', DonationController::class)->except(['edit', 'update']);

    // Order Routes
    Route::resource('orders', OrderController::class)->except(['edit', 'update']);

    // Reservation Routes
    Route::resource('reservations', ReservationController::class);

    Route::view('dashboard', 'dashboard')->name('dashboard');
});

Route::get('/waste2product', function () {
    return view('front.home');
});

Route::get('/shop', function () {
    return view('front.products');
})->name('front.products');

Route::view('/recycling', 'front.recycling');
Route::view('/contact', 'front.contact');

require __DIR__.'/auth.php';
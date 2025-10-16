<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Frontoffice home route (public first)
Route::get('/waste2product', function () {
    return view('front.home');
});

// Frontoffice Routes (Public - Defined BEFORE auth to avoid conflicts)
Route::get('/donations', [DonationController::class, 'index'])->name('front.donations.index');
Route::get('/donations/create', [DonationController::class, 'create'])->name('front.donations.create');
Route::post('/donations', [DonationController::class, 'store'])->name('front.donations.store');
Route::get('/donations/{donation}', [DonationController::class, 'show'])->name('front.donations.show');
Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])->name('front.donations.destroy');
Route::get('/donations/{donation}/edit', [DonationController::class, 'edit'])->name('front.donations.edit');
Route::put('/donations/{donation}', [DonationController::class, 'update'])->name('front.donations.update');
Route::post('/donations/ai-classify', [DonationController::class, 'aiClassify'])->name('front.donations.ai-classify');

Route::get('/orders', [OrderController::class, 'index'])->name('front.orders.index');
Route::get('/orders/create', [OrderController::class, 'create'])->name('front.orders.create');
Route::post('/orders', [OrderController::class, 'store'])->name('front.orders.store');
Route::get('/orders/{order}', [OrderController::class, 'show'])->name('front.orders.show');
Route::get('/orders/{order}/edit', [OrderController::class, 'edit'])->name('front.orders.edit');
Route::put('/orders/{order}', [OrderController::class, 'update'])->name('front.orders.update');
Route::delete('/orders/{order}', [OrderController::class, 'destroy'])->name('front.orders.destroy');

Route::get('/reservations', [ReservationController::class, 'index'])->name('front.reservations.index');
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('front.reservations.create');
Route::post('/reservations', [ReservationController::class, 'store'])->name('front.reservations.store');
Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('front.reservations.show');
Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('front.reservations.edit');
Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('front.reservations.update');
Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('front.reservations.destroy');

Route::get('/shop', function () {
    return view('front.products');
})->name('front.products');

Route::view('/recycling', 'front.recycling');
Route::view('/contact', 'front.contact');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Back-end Routes (Back - Prefixed with /admin to avoid conflicts)
    Route::prefix('back')->name('back.')->group(function () {
        // Donations (Back-end)
        Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
        Route::get('donations/create', [DonationController::class, 'create'])->name('donations.create');
        Route::post('donations', [DonationController::class, 'store'])->name('donations.store');
        Route::get('donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
        Route::delete('donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');
        Route::put('donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
        Route::get('donations/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');

        // Orders (Back-end)
        Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
        Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
        Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
        Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
        Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
        Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
        Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

        // Reservations (Back-end)
        Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
        Route::get('reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
        Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
        Route::get('reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
        Route::get('reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
        Route::put('reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
        Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

        // Products (Back-end)
        Route::resource('products', ProductController::class)->names('products');
    });

    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/auth.php';
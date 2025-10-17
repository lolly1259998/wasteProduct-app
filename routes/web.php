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
})->name('front.home');

// Frontoffice Routes (Public - Prefixed with /waste2product)
Route::prefix('waste2product')->name('front.')->group(function () {
    // Donations (Frontoffice)
    Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
    Route::get('donations/create', [DonationController::class, 'create'])->name('donations.create');
    Route::post('donations', [DonationController::class, 'store'])->name('donations.store');
    Route::get('donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
    Route::delete('donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');
    Route::get('donations/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');
    Route::put('donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
    Route::post('analyze-sentiment', [DonationController::class, 'analyzeSentiment'])->name('donations.analyze-sentiment');

    // Orders (Frontoffice)
    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('orders/{order}/edit', [OrderController::class, 'edit'])->name('orders.edit');
    Route::put('orders/{order}', [OrderController::class, 'update'])->name('orders.update');
    Route::delete('orders/{order}', [OrderController::class, 'destroy'])->name('orders.destroy');

    // Reservations (Frontoffice)
    Route::get('reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::get('reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');

   
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Back-end Routes (Back - Prefixed with /back)
    Route::prefix('back')->name('back.')->group(function () {
        Route::get('home', function () {
            $totalDonations = \App\Models\Donation::count();
            $totalOrders = \App\Models\Order::count();
            $totalReservations = \App\Models\Reservation::count();
            return view('back.home', compact('totalDonations', 'totalOrders', 'totalReservations'));
        })->name('home');

        Route::prefix('home')->group(function () {
            // Donations (Back-end)
            Route::get('donations', [DonationController::class, 'index'])->name('donations.index');
            Route::get('donations/create', [DonationController::class, 'create'])->name('donations.create');
            Route::post('donations', [DonationController::class, 'store'])->name('donations.store');
            Route::get('donations/{donation}', [DonationController::class, 'show'])->name('donations.show');
            Route::delete('donations/{donation}', [DonationController::class, 'destroy'])->name('donations.destroy');
            Route::put('donations/{donation}', [DonationController::class, 'update'])->name('donations.update');
            Route::get('donations/{donation}/edit', [DonationController::class, 'edit'])->name('donations.edit');
            Route::post('donations/analyze-sentiment', [DonationController::class, 'analyzeSentiment'])->name('donations.analyze-sentiment');

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

        
        });
    });

    Route::get('dashboard', function () {
        return redirect()->route('back.home');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
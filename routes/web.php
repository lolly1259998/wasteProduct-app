<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RecyclingProcessController;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    // Recycling workflow routes
    Route::get('recycling/processes', [RecyclingProcessController::class, 'index'])->name('recycling.index');
    Route::get('recycling/processes/create', [RecyclingProcessController::class, 'create'])->name('recycling.create');
    Route::post('recycling/processes', [RecyclingProcessController::class, 'store'])->name('recycling.store');
    Route::get('recycling/processes/{recycling}', [RecyclingProcessController::class, 'show'])->name('recycling.show');
    Route::get('recycling/processes/{recycling}/complete', [RecyclingProcessController::class, 'complete'])->name('recycling.complete');
    Route::put('recycling/processes/{recycling}/complete', [RecyclingProcessController::class, 'updateComplete'])->name('recycling.updateComplete');
});
Route::get('/waste2product', function () {
    return view('front.home');
});
Route::view('/products', 'front.products');
Route::view('/recycling', 'front.recycling');
Route::view('/donations', 'front.donations');
Route::view('/contact', 'front.contact');
Route::get('/back/home', function () {
    return view('back.home');
});


require __DIR__.'/auth.php';

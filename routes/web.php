<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice\WasteCategoryController;
use App\Models\WasteCategory; // ✅ Import du modèle

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

   
    Route::get('dashboard', function () {
        $categories = WasteCategory::all(); 
        return view('dashboard', compact('categories')); 
    })->middleware(['auth', 'verified'])->name('dashboard');
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

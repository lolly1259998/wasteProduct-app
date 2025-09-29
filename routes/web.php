<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice\WasteCategoryController;
use App\Models\WasteCategory;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    
    Route::get('waste-categories', [WasteCategoryController::class, 'index'])
        ->name('waste_categories.index');
    Route::get('waste-categories/create', [WasteCategoryController::class, 'create'])
        ->name('waste_categories.create');
    Route::post('waste-categories', [WasteCategoryController::class, 'store'])
        ->name('waste_categories.store');
    Route::get('waste-categories/{id}/edit', [WasteCategoryController::class, 'edit'])
        ->name('waste_categories.edit');
    Route::put('waste-categories/{id}', [WasteCategoryController::class, 'update'])
        ->name('waste_categories.update');
    Route::delete('waste-categories/{id}', [WasteCategoryController::class, 'destroy'])
        ->name('waste_categories.destroy');
    Route::get('waste-categories/{id}', [WasteCategoryController::class, 'show'])
        ->name('waste_categories.show');
   
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


require __DIR__.'/auth.php';

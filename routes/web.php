<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backoffice\WasteCategoryController;
use App\Http\Controllers\Backoffice\WasteController;
use App\Models\WasteCategory;
use APP\Models\Waste;
use app\Models\CollectionPoint;
use App\Http\Controllers\Front\FrontWasteCategoryController;
use App\Http\Controllers\Front\FrontWasteController;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');

    //Waste Routes
    Route::get('wastes', [WasteController::class, 'index'])->name('wastes.index');
    Route::get('wastes/create', [WasteController::class, 'create'])->name('wastes.create');
    Route::post('wastes', [WasteController::class, 'store'])->name('wastes.store');
    Route::get('wastes/{id}/edit', [WasteController::class, 'edit'])->name('wastes.edit');
    Route::put('wastes/{id}', [WasteController::class, 'update'])->name('wastes.update');
    Route::delete('wastes/{id}', [WasteController::class, 'destroy'])->name('wastes.destroy');
    Route::get('wastes/{id}', [WasteController::class, 'show'])->name('wastes.show');

    //Waste Category Routes
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

    
    
    //Dashboard Route
    Route::get('dashboard', function () {
        $categories = WasteCategory::all(); 
        return view('dashboard', compact('categories')); 

    })->middleware(['auth', 'verified'])->name('dashboard');
});

//frontoffice home route
Route::get('/waste2product', function () {
    return view('front.home');
});
// Frontoffice Waste Category Routes
Route::get('/categories', [FrontWasteCategoryController::class, 'index'])->name('front.waste-categories.index');
Route::get('/categories/create', [FrontWasteCategoryController::class, 'create'])->name('front.waste-categories.create');
Route::post('/categories', [FrontWasteCategoryController::class, 'store'])->name('front.waste-categories.store');
Route::get('/categories/{id}', [FrontWasteCategoryController::class, 'show'])->name('front.waste-categories.show');
Route::get('/categories/{id}/edit', [FrontWasteCategoryController::class, 'edit'])->name('front.waste-categories.edit');
Route::put('/categories/{id}', [FrontWasteCategoryController::class, 'update'])->name('front.waste-categories.update');
Route::delete('/categories/{id}', [FrontWasteCategoryController::class, 'destroy'])->name('front.waste-categories.destroy');

// Frontoffice Waste Routes
Route::get('/wastess', [FrontWasteController::class, 'index'])->name('front.wastes.index');
Route::get('/wastess/create', [FrontWasteController::class, 'create'])->name('front.wastes.create');
Route::post('/wastess', [FrontWasteController::class, 'store'])->name('front.wastes.store');
Route::get('/wastess/{id}', [FrontWasteController::class, 'show'])->name('front.wastes.show');       
Route::get('/wastess/{id}/edit', [FrontWasteController::class, 'edit'])->name('front.wastes.edit');
Route::put('/wastess/{id}', [FrontWasteController::class, 'update'])->name('front.wastes.update');
Route::delete('/wastess/{id}', [FrontWasteController::class, 'destroy'])->name('front.wastes.destroy');





Route::view('/products', 'front.products');
Route::view('/recycling', 'front.recycling');
Route::view('/donations', 'front.donations');
Route::view('/contact', 'front.contact');
Route::get('/back/home', function () {
    return view('back.home');
});

require __DIR__.'/auth.php';

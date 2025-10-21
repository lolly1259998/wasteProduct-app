<?php
use App\Http\Controllers\DonationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
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
use App\Http\Controllers\AI\AIController;
use App\Http\Controllers\AI\WasteAIController;
use App\Http\Controllers\AI\RecyclingAIController;
use App\Http\Controllers\Backoffice\CollectionPointController;
use App\Http\Controllers\Front\CollectionPointFrontController;
use App\Http\Controllers\Backoffice\RecyclingProcessController;
use App\Http\Controllers\Backoffice\ProductController;
use App\Http\Controllers\Front\ProductFrontController;
use App\Http\Controllers\AI\CollectionAIController;
use App\Http\Controllers\Campaign\CampaignController;



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

    // Recycling Process Routes (Back-office)
    Route::resource('recyclingprocesses', RecyclingProcessController::class);

    // Product Routes (Back-office)
    Route::resource('products', ProductController::class);
    Route::post('products/{id}/toggle-availability', [ProductController::class, 'toggleAvailability'])
        ->name('products.toggle-availability');

    Route::view('dashboard', 'back.home')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
    
    //Dashboard Route
    Route::get('/back/home', function () {
     $categories = \App\Models\WasteCategory::all();
    $wastes = \App\Models\Waste::all();
$totalWastes = $wastes->count();
    $wasteStats = $categories->map(function ($category) use ($wastes, $totalWastes) {
        $count = $wastes->where('waste_category_id', $category->id)->count();
        $percentage = $totalWastes > 0 ? ($count / $totalWastes) * 100 : 0;
        return [
            'name' => $category->name,
            'percentage' => round($percentage, 1),
        ];
    });
        return view('back.home', compact('categories', 'wastes', 'wasteStats'));
    })->middleware(['auth', 'verified'])->name('back.home');

    Route::get('/collection-ai/train/{id}', [CollectionAIController::class, 'train']);
    Route::get('/collection-ai/predict/{id}', [CollectionAIController::class, 'predict']);

Route::get('/collection-ai/train/{id}', [CollectionAIController::class, 'train']);
Route::get('/collection-ai/predict/{id}', [CollectionAIController::class, 'predict']);

Route::get('/collectionpoints/predictions', [CollectionPointController::class, 'predictions'])
    ->name('collectionpoints.predictions');

//frontoffice home route
    // Product Routes
    Route::resource('products', ProductController::class);

    // Donation Routes
    Route::resource('donations', DonationController::class)->except(['edit', 'update']);

    // Order Routes
    Route::resource('orders', OrderController::class)->except(['edit', 'update']);

    // Reservation Routes
    Route::resource('reservations', ReservationController::class);

//frontoffice home route
    // Product Routes
    Route::resource('products', ProductController::class);

    // Donation Routes
    Route::resource('donations', DonationController::class)->except(['edit', 'update']);

    // Order Routes
    Route::resource('orders', OrderController::class)->except(['edit', 'update']);

    // Reservation Routes
    Route::resource('reservations', ReservationController::class);
});

//frontoffice home route
Route::get('/waste2product', function () {
    return view('front.home');
});

//frontoffice campaigns routes


Route::get('/campaignsFront', [CampaignController::class, 'frontIndex'])->name('campaigns.front');

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

Route::post('/ai/predict', [AIController::class, 'predictWaste'])->name('ai.predict');
Route::get('/predictwaste', function () {
    return view('predictwaste');
})->name('predictwaste');
Route::get('/ai-advice', [WasteAIController::class, 'showForm'])->name('ai.advice.form');
Route::post('/ai-advice', [WasteAIController::class, 'recycling'])->name('ai.advice.recycling');

// Démo IA pour le module Recyclage
Route::get('/ai/recycling/demo', function () {
    return view('ai.recycling-ai-demo');
})->name('ai.recycling.demo');

// Routes IA pour le module Recyclage
Route::prefix('ai/recycling')->group(function () {
    Route::post('/classify-waste', [RecyclingAIController::class, 'classifyWaste'])->name('ai.recycling.classify');
    Route::post('/predict-quality', [RecyclingAIController::class, 'predictQuality'])->name('ai.recycling.predict-quality');
    Route::post('/estimate-price', [RecyclingAIController::class, 'estimatePrice'])->name('ai.recycling.estimate-price');
    Route::post('/generate-description', [RecyclingAIController::class, 'generateDescription'])->name('ai.recycling.generate-description');
    Route::post('/optimize-process', [RecyclingAIController::class, 'optimizeProcess'])->name('ai.recycling.optimize-process');
    Route::get('/health', [RecyclingAIController::class, 'healthCheck'])->name('ai.recycling.health');
});

// Product Routes (Front-office) - Utiliser un chemin différent pour éviter les conflits
Route::get('/shop/products', [ProductFrontController::class, 'index'])->name('front.products.index');
Route::get('/shop/products/{id}', [ProductFrontController::class, 'show'])->name('front.products.show');

Route::view('/recycling', 'front.recycling');
Route::view('/contact', 'front.contact');

Route::get('/dashbored/collectionpoints', action: [CollectionPointController::class, 'index'])->name('back.home');
Route::resource('collectionpoints', CollectionPointController::class);

Route::get('/waste2product/collectionpoints', [CollectionPointFrontController::class, 'index'])->name('front.collectionpoints.index');
Route::get('/waste2product/collectionpoints/{id}', [CollectionPointFrontController::class, 'show'])->name('front.collectionpoints.show');

// Route pour la page de gestion des campagnes dans le back-office
Route::get('/back/campaigns', function () {
    return view('back.campaign.campaigns');
})->name('back.campaigns');

// Routes RESTful pour l'API des campagnes
Route::resource('campaigns', CampaignController::class);

require __DIR__.'/auth.php';
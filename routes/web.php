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
use App\Http\Controllers\Backoffice\ProfileController;
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
use App\Http\Controllers\Participants\ParticipationController;
use App\Http\Controllers\Auth\AuthentifController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Backoffice\UserBackendController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Auth;

// ========== PUBLIC ROUTES ==========

// Home
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Front-office Home
Route::get('/waste2product', function () {
    return view('front.home');
})->name('front.home');

// Static pages
Route::view('/recycling', 'front.recycling');
Route::view('/contact', 'front.contact');

// AI Prediction
Route::get('/predictwaste', function () {
    return view('predictwaste');
})->name('predictwaste');
Route::post('/ai/predict', [AIController::class, 'predictWaste'])->name('ai.predict');
Route::get('/ai-advice', [WasteAIController::class, 'showForm'])->name('ai.advice.form');
Route::post('/ai-advice', [WasteAIController::class, 'recycling'])->name('ai.advice.recycling');

// AI Recycling Demo
Route::get('/ai/recycling/demo', function () {
    return view('ai.recycling-ai-demo');
})->name('ai.recycling.demo');

// AI Recycling Routes
Route::prefix('ai/recycling')->group(function () {
    Route::post('/classify-waste', [RecyclingAIController::class, 'classifyWaste'])->name('ai.recycling.classify');
    Route::post('/predict-quality', [RecyclingAIController::class, 'predictQuality'])->name('ai.recycling.predict-quality');
    Route::post('/estimate-price', [RecyclingAIController::class, 'estimatePrice'])->name('ai.recycling.estimate-price');
    Route::post('/generate-description', [RecyclingAIController::class, 'generateDescription'])->name('ai.recycling.generate-description');
    Route::post('/optimize-process', [RecyclingAIController::class, 'optimizeProcess'])->name('ai.recycling.optimize-process');
    Route::get('/health', [RecyclingAIController::class, 'healthCheck'])->name('ai.recycling.health');
});

// ========== FRONT-OFFICE ROUTES (Public) ==========

// Campaigns
Route::get('/campaignsFront', [CampaignController::class, 'frontIndex'])->name('campaigns.front');

// Waste Categories (Front)
Route::get('/categories', [FrontWasteCategoryController::class, 'index'])->name('front.waste-categories.index');
Route::get('/categories/{id}', [FrontWasteCategoryController::class, 'show'])->name('front.waste-categories.show');

// Wastes (Front)
Route::get('/wastess', [FrontWasteController::class, 'index'])->name('front.wastes.index');
Route::get('/wastess/{id}', [FrontWasteController::class, 'show'])->name('front.wastes.show');

// Products (Front)
Route::get('/shop/products', [ProductFrontController::class, 'index'])->name('front.products.index');
Route::get('/shop/products/{id}', [ProductFrontController::class, 'show'])->name('front.products.show');

// Collection Points (Front)
Route::get('/waste2product/collectionpoints', [CollectionPointFrontController::class, 'index'])->name('front.collectionpoints.index');
Route::get('/waste2product/collectionpoints/{id}', [CollectionPointFrontController::class, 'show'])->name('front.collectionpoints.show');

// ========== AUTH ROUTES ==========
Route::get('/register', [AuthentifController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthentifController::class, 'register'])->name('register');

Route::get('/login', [AuthentifController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthentifController::class, 'login'])->name('login');
Route::post('/logout', [AuthentifController::class, 'logout'])->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

// ========== AUTHENTICATED ROUTES ==========
Route::middleware(['auth'])->group(function () {
    
    // Profile
    Route::get('/profile', function () {
        $user = Auth::user();
        return view('front.profil.profile', compact('user'));
    })->name('profile.view');

    // Settings
    Route::redirect('settings', 'settings/profile');
    Route::get('settings/profile', Profile::class)->name('settings.profile');
    Route::get('settings/password', Password::class)->name('settings.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
    
    // Password Management
    Route::get('settings/password', [UserController::class, 'editPassword'])->name('settings.password.edit');
    Route::put('settings/password', [UserController::class, 'updatePassword'])->name('settings.password.update');

    // Campaign Participation
    Route::get('/campaigns/{campaign}/check', [ParticipationController::class, 'check'])->name('campaigns.check');
    Route::post('/campaigns/{campaign}/toggle', [ParticipationController::class, 'toggle'])->name('campaigns.toggle');
    Route::get('/ai/recommendations', [CampaignController::class, 'recommendAI'])->name('campaigns.recommend-ai');

    // Front-office Donations/Orders/Reservations (under /waste2product)
    Route::prefix('waste2product')->name('front.')->group(function () {
        Route::resource('donations', DonationController::class);
        Route::post('analyze-sentiment', [DonationController::class, 'analyzeSentiment'])->name('donations.analyze-sentiment');
        
        Route::resource('orders', OrderController::class);
        Route::resource('reservations', ReservationController::class);
    });
});

// ========== BACK-OFFICE ROUTES ==========
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard redirect
    Route::get('/dashboard', function () {
        return redirect()->route('back.home');
    })->name('dashboard');

    // Main Backoffice Dashboard
    Route::get('/back/home', function () {
        $categories = \App\Models\WasteCategory::all();
        $wastes = \App\Models\Waste::all();
        $totalWastes = $wastes->count();
        $totalDonations = \App\Models\Donation::count();
        $totalOrders = \App\Models\Order::count();
        $totalReservations = \App\Models\Reservation::count();
        
        $wasteStats = $categories->map(function ($category) use ($wastes, $totalWastes) {
            $count = $wastes->where('waste_category_id', $category->id)->count();
            $percentage = $totalWastes > 0 ? ($count / $totalWastes) * 100 : 0;
            return [
                'name' => $category->name,
                'percentage' => round($percentage, 1),
            ];
        });
        
        return view('back.home', compact('categories', 'wastes', 'wasteStats', 'totalDonations', 'totalOrders', 'totalReservations'));
    })->name('back.home');

    // Waste Management
    Route::resource('wastes', WasteController::class);
    Route::resource('waste-categories', WasteCategoryController::class);

    // Products
    Route::resource('products', ProductController::class);
    Route::post('products/{id}/toggle-availability', [ProductController::class, 'toggleAvailability'])->name('products.toggle-availability');

    // Recycling Processes
    Route::resource('recyclingprocesses', RecyclingProcessController::class);

    // Collection Points
    Route::resource('collectionpoints', CollectionPointController::class);
    Route::get('/collectionpoints/predictions', [CollectionPointController::class, 'predictions'])->name('collectionpoints.predictions');
    Route::get('/collection-ai/train/{id}', [CollectionAIController::class, 'train']);
    Route::get('/collection-ai/predict/{id}', [CollectionAIController::class, 'predict']);

    // Campaigns (API + Backoffice)
    Route::resource('campaigns', CampaignController::class);
    Route::get('/back/campaigns', function () {
        return view('back.campaign.campaigns');
    })->name('back.campaigns');

    // Participants Management
    Route::get('/back/participants', [ParticipationController::class, 'index'])->name('back.participants');
    Route::get('/back/participants/{campaignId}', [ParticipationController::class, 'index'])->name('back.participants.campaign');
    Route::get('/admin/participants', [ParticipationController::class, 'listAll'])->name('participants.all');
    Route::get('/admin/participants/{campaignId}', [ParticipationController::class, 'list'])->name('participants.list');
    Route::put('/admin/participants/{id}/approve', [ParticipationController::class, 'approve'])->name('participants.approve');
    Route::delete('/admin/participants/{id}', [ParticipationController::class, 'destroy'])->name('participants.destroy');

    // Users Management
    Route::prefix('back')->name('back.')->group(function () {
        Route::get('/users', [UserBackendController::class, 'index'])->name('users.index');
        Route::get('/users/list', [UserBackendController::class, 'list'])->name('users.list');
        Route::put('/users/{id}', [UserBackendController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserBackendController::class, 'destroy'])->name('users.destroy');
    });

    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    // Backoffice Donations/Orders/Reservations
    Route::resource('donations', DonationController::class);
    Route::post('donations/analyze-sentiment', [DonationController::class, 'analyzeSentiment'])->name('donations.analyze-sentiment');
    Route::resource('orders', OrderController::class);
    Route::resource('reservations', ReservationController::class);
});

// Backoffice Profile
Route::get('/back/profile', [ProfileController::class, 'index'])->name('back.profile');
<?php

use App\Http\Controllers\DonationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Http\Controllers\Backoffice\WasteCategoryController;
use App\Http\Controllers\Backoffice\WasteController;
use App\Models\WasteCategory;
use App\Models\Waste;
use App\Models\CollectionPoint;
use App\Http\Controllers\Front\FrontWasteCategoryController;
use App\Http\Controllers\Front\FrontWasteController;
use App\Http\Controllers\AI\AIController;
use App\Http\Controllers\AI\WasteAIController;
use App\Http\Controllers\AI\RecyclingAIController;
use App\Http\Controllers\Backoffice\CollectionPointController;
use App\Http\Controllers\Front\CollectionPointFrontController;
use App\Http\Controllers\AI\CollectionAIController;
use App\Http\Controllers\Backoffice\ProductController as BackofficeProductController;
use App\Http\Controllers\Campaign\CampaignController;
use App\Http\Controllers\Front\ProductFrontController;
use App\Http\Controllers\Backoffice\RecyclingProcessController;
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

    // Back-end Routes (Back - Prefixed with /back)
    Route::prefix('back')->name('back.')->group(function () {
        Route::get('home', function () {
            $totalDonations = \App\Models\Donation::count();
            $totalOrders = \App\Models\Order::count();
            $totalReservations = \App\Models\Reservation::count();
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
            return view('back.home', compact('totalDonations', 'totalOrders', 'totalReservations', 'categories', 'wastes', 'wasteStats'));
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

            // Waste Routes (Back-end)
            Route::get('wastes', [WasteController::class, 'index'])->name('wastes.index');
            Route::get('wastes/create', [WasteController::class, 'create'])->name('wastes.create');
            Route::post('wastes', [WasteController::class, 'store'])->name('wastes.store');
            Route::get('wastes/{id}/edit', [WasteController::class, 'edit'])->name('wastes.edit');
            Route::put('wastes/{id}', [WasteController::class, 'update'])->name('wastes.update');
            Route::delete('wastes/{id}', [WasteController::class, 'destroy'])->name('wastes.destroy');
            Route::get('wastes/{id}', [WasteController::class, 'show'])->name('wastes.show');

            // Waste Category Routes (Back-end)
            Route::get('waste-categories', [WasteCategoryController::class, 'index'])->name('waste_categories.index');
            Route::get('waste-categories/create', [WasteCategoryController::class, 'create'])->name('waste_categories.create');
            Route::post('waste-categories', [WasteCategoryController::class, 'store'])->name('waste_categories.store');
            Route::get('waste-categories/{id}/edit', [WasteCategoryController::class, 'edit'])->name('waste_categories.edit');
            Route::put('waste-categories/{id}', [WasteCategoryController::class, 'update'])->name('waste_categories.update');
            Route::delete('waste-categories/{id}', [WasteCategoryController::class, 'destroy'])->name('waste_categories.destroy');
            Route::get('waste-categories/{id}', [WasteCategoryController::class, 'show'])->name('waste_categories.show');

            // Recycling Process Routes (Back-office)
            Route::resource('recyclingprocesses', RecyclingProcessController::class);

            // Product Routes (Back-office)
            Route::resource('products', BackofficeProductController::class);
            Route::post('products/{id}/toggle-availability', [BackofficeProductController::class, 'toggleAvailability'])->name('products.toggle-availability');

            // Collection Points (Back-end)
            Route::resource('collectionpoints', CollectionPointController::class);
            Route::get('collectionpoints/predictions', [CollectionPointController::class, 'predictions'])->name('collectionpoints.predictions');
        });

        // Back-office Campaigns
        Route::get('campaigns', function () {
            return view('back.campaign.campaigns');
        })->name('campaigns');
    });

    // Collection AI Routes
    Route::get('/collection-ai/train/{id}', [CollectionAIController::class, 'train']);
    Route::get('/collection-ai/predict/{id}', [CollectionAIController::class, 'predict']);

    // Back-end Campaigns API
    Route::resource('campaigns', CampaignController::class);

    Route::get('dashboard', function () {
        return redirect()->route('back.home');
    })->name('dashboard');
});

require __DIR__.'/auth.php';
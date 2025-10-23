<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\Donation;
use App\Models\Order;
use App\Models\Reservation;
use App\Policies\DonationPolicy;
use App\Policies\OrderPolicy;
use App\Policies\ReservationPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Order::class => OrderPolicy::class,
        Donation::class => DonationPolicy::class,
        Reservation::class => ReservationPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // ✅ Custom validation messages (English version)
        Validator::replacer('required', function ($message, $attribute) {
            return "The $attribute field is required.";
        });

        Validator::replacer('email', function ($message, $attribute) {
            return "The $attribute field must be a valid email address.";
        });

        Validator::replacer('confirmed', function ($message, $attribute) {
            return "The $attribute confirmation does not match.";
        });

        Validator::replacer('min', function ($message, $attribute, $rule, $parameters) {
            return "The $attribute field must be at least {$parameters[0]} characters long.";
        });
    }
}

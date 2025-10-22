<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Socialite\Contracts\Factory;

class SocialiteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $socialite = $this->app->make(Factory::class);

        // Configuration pour ignorer les erreurs SSL en développement
        if (app()->environment('local')) {
            $socialite->extend('google', function ($app) use ($socialite) {
                $config = $app['config']['services.google'];
                return $socialite->buildProvider(\Laravel\Socialite\Two\GoogleProvider::class, $config)
                    ->setHttpClient(new \GuzzleHttp\Client([
                        'verify' => false,
                    ]));
            });
        }
    }
}
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
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
        // Register custom Brevo API mail driver
        try {
            \Illuminate\Support\Facades\Mail::extend('brevo-api', function (array $config) {
                return new \App\Mail\Transports\BrevoApiTransport(
                    $config['key'],
                    config('mail.from.address'),
                    config('mail.from.name')
                );
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to extend mailer with brevo-api driver: ' . $e->getMessage());
        }

        try {
            if (config('database.default') && \Illuminate\Support\Facades\Schema::hasTable('settings')) {
                \Illuminate\Support\Facades\View::share('settings', \App\Models\Setting::first());
            } else {
                \Illuminate\Support\Facades\View::share('settings', null);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('settings', null);
        }
    }
}

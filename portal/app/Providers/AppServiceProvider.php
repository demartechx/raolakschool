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
        if ($this->app->environment('production') || $this->app->environment('local')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // Fix Livewire asset URL for subdirectory deployment (e.g., /portal/public/)
        // This overrides any cached config value at runtime
        $appUrl = config('app.url', '');
        if ($appUrl && !str_ends_with($appUrl, '/public')) {
            config(['livewire.asset_url' => $appUrl . '/public']);
        }
    }
}

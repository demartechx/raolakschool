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
        if ($this->app->environment('production')) {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }

        // When Laravel runs in a subdirectory (e.g. /portal/public/), all URL
        // generation (Livewire endpoint, Filament assets, route()) must use that
        // subdirectory as the root. We detect it automatically from SCRIPT_NAME
        // so APP_URL can stay as the bare domain (https://school.raolak.com).
        if (!$this->app->runningInConsole()) {
            $scriptName = request()->server('SCRIPT_NAME', '');
            $basePath = rtrim(\dirname($scriptName), '/');

            if ($basePath && $basePath !== '.' && $basePath !== '/') {
                $rootUrl = rtrim(config('app.url'), '/') . $basePath;

                // Fix url(), route() — includes Livewire's update endpoint
                \Illuminate\Support\Facades\URL::forceRootUrl($rootUrl);

                // Fix Livewire JS asset URL explicitly
                config(['livewire.asset_url' => $rootUrl]);
            }
        }
    }
}

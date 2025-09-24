<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::defaultView('vendor.pagination.bootstrap-4');

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // if (config('app.env') == 'local') { // Skip HTTPS on local
        //URL::forceScheme('https');

    }
}

<?php

namespace App\Providers;

use App\Models\SiteAdmin;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


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
        Paginator::useBootstrapFour();
        // $logoName = SiteAdmin::select('name')->first();
        // View::share('logoName', $logoName);
    }
}

<?php

namespace App\Providers;

use App\Models\LandingSection;
use App\Models\Staff;
use App\Observers\LandingSectionObserver;
use App\Observers\StaffObserver;
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
        Staff::observe(StaffObserver::class);
        LandingSection::observe(LandingSectionObserver::class);
    }
}

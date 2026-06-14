<?php

namespace App\Providers;

use App\Models\LandingSection;
use App\Models\Staff;
use App\Observers\LandingSectionObserver;
use App\Observers\StaffObserver;
use Illuminate\Support\Facades\View;
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

        View::composer(['landing.layout', 'landing.partials.nav', 'farmer.layouts.app', 'farmer.layouts.partials.nav'], function ($view) {
            $view->with('enabledModules', \App\Support\AgriculturalContentCatalog::enabledModules());
        });

        View::composer('admin.layouts.root', function ($view) {
            $user = auth()->user();

            if ($user && $user->isBackOffice()) {
                $view->with([
                    'unreadNotifications' => $user->unreadNotifications()->latest()->limit(10)->get(),
                    'unreadNotificationCount' => $user->unreadNotifications()->count(),
                ]);
            }
        });
    }
}

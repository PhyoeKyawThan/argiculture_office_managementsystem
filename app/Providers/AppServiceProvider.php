<?php

namespace App\Providers;

use App\Models\Category;
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

        View::composer(['components.content-module-nav', 'admin.announcements.index'], function ($view) {
            $view->with('categories', Category::with('children.children.children')
                ->whereNull('parent_id')
                ->orderBy('name')
                ->get());
        });

        View::composer(['admin.layouts.root', 'shop.layouts.root'], function ($view) {
            $user = auth()->user();

            if ($user) {
                $view->with([
                    'unreadNotifications' => $user->unreadNotifications()->latest()->limit(10)->get(),
                    'unreadNotificationCount' => $user->unreadNotifications()->count(),
                ]);
            }
        });
    }
}

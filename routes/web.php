<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LandingSectionController;
use App\Http\Controllers\Admin\PesticideShopInspectionController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\Shop\DashboardController as ShopDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/', [LandingController::class, 'index'])->name('landing.home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:shop'])->prefix('shop')->name('shop.')->group(function () {
    Route::get('/dashboard', [ShopDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('staff', StaffController::class);
    Route::resource('pesticide-shop-inspections', PesticideShopInspectionController::class);

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('landing-sections', LandingSectionController::class)->except(['show']);
    });
});

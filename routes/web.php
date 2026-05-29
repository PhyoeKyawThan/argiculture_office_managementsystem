<?php

use App\Http\Controllers\Auth\FarmerRegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AgriculturalAnnouncementController;
use App\Http\Controllers\Admin\AgriculturalInquiryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LandingSectionController;
use App\Http\Controllers\Admin\PesticideShopInspectionController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Farmer\DashboardController as FarmerDashboardController;
use App\Http\Controllers\Farmer\InquiryController as FarmerInquiryController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Shop\DashboardController as ShopDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/', [LandingController::class, 'index'])->name('landing.home');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/{announcement:slug}', [NewsController::class, 'show'])->name('news.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
    Route::get('/farmer/register', [FarmerRegisterController::class, 'create'])->name('farmer.register');
    Route::post('/farmer/register', [FarmerRegisterController::class, 'store'])->name('farmer.register.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:shop'])->prefix('shop')->name('shop.')->group(function () {
    Route::get('/dashboard', [ShopDashboardController::class, 'index'])->name('dashboard');
});

Route::middleware(['auth', 'role:farmer'])->prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [FarmerDashboardController::class, 'index'])->name('dashboard');
    Route::resource('inquiries', FarmerInquiryController::class)->only(['index', 'create', 'store', 'show']);
});

Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::resource('staff', StaffController::class);
    Route::resource('pesticide-shop-inspections', PesticideShopInspectionController::class);
    Route::resource('inquiries', AgriculturalInquiryController::class)->only(['index', 'show', 'update']);
    Route::resource('announcements', AgriculturalAnnouncementController::class)->except(['show']);

    Route::middleware('role:admin')->group(function () {
        Route::resource('users', UserController::class)->except(['show']);
        Route::resource('landing-sections', LandingSectionController::class)->except(['show']);
    });
});

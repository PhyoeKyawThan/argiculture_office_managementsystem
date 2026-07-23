<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\FarmerRegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ShopRegisterController;
use App\Http\Controllers\Admin\AgriculturalAnnouncementController;
use App\Http\Controllers\Admin\AgriculturalInquiryController;
use App\Http\Controllers\Admin\FertilizerLicenseController as AdminFertilizerLicenseController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FeatureSettingController;
use App\Http\Controllers\Admin\LandingSectionController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\PesticideShopController as AdminPesticideShopController;
use App\Http\Controllers\Shop\PesticideShopController as ShopPesticideShopController;
use App\Http\Controllers\Admin\PesticideShopInspectionController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Farmer\DashboardController as FarmerDashboardController;
use App\Http\Controllers\Farmer\InquiryController as FarmerInquiryController;
use App\Http\Controllers\Farmer\NotificationController as FarmerNotificationController;
use App\Http\Controllers\Shop\FertilizerLicenseController as ShopFertilizerLicenseController;
use App\Http\Controllers\Shop\NotificationController as ShopNotificationController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LocaleController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Shop\DashboardController as ShopDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/locale/{locale}', [LocaleController::class, 'switch'])->name('locale.switch');

Route::get('/', [LandingController::class, 'index'])->name('landing.home');

Route::get('/news', [NewsController::class, 'index'])->name('news.index');
Route::get('/news/category/{categorySlug}', [NewsController::class, 'index'])->name('news.category');
Route::get('/news/{announcement:slug}', [NewsController::class, 'show'])->name('news.show');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');

    Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])->name('password.request');
    Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])->name('password.store');
    Route::get('/reset-password', [ResetPasswordController::class, 'create'])->name('password.reset');
    Route::post('/reset-password', [ResetPasswordController::class, 'store'])->name('password.reset.store');

    Route::middleware('feature:farmer_registration')->group(function () {
        Route::get('/farmer/register', [FarmerRegisterController::class, 'create'])->name('farmer.register');
        Route::post('/farmer/register', [FarmerRegisterController::class, 'store'])->name('farmer.register.store');
    });

    Route::middleware('feature:shop_registration')->group(function () {
        Route::get('/shop/register', [ShopRegisterController::class, 'create'])->name('shop.register');
        Route::post('/shop/register', [ShopRegisterController::class, 'store'])->name('shop.register.store');
    });
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::middleware(['auth', 'role:shop'])->prefix('shop')->name('shop.')->group(function () {
    Route::get('/dashboard', [ShopDashboardController::class, 'index'])->name('dashboard');
    Route::get('/license-register', [ShopPesticideShopController::class, 'licenseRegisterationForm'])->name('licenseRegisterationForm');
    Route::post('/license-register', [ShopPesticideShopController::class, 'store'])->name('storeLicenseApplication');
    Route::get('/license/edit/{id}', [ShopPesticideShopController::class, 'licenseEditForm'])->name('licenseEditForm');
    Route::put('/shop/license/update/{id}', [ShopPesticideShopController::class, 'update'])->name('licenseUpdate');
    Route::get('/fertilizer-licenses/apply', [ShopFertilizerLicenseController::class, 'create'])->name('fertilizer-licenses.create');
    Route::post('/fertilizer-licenses', [ShopFertilizerLicenseController::class, 'store'])->name('fertilizer-licenses.store');
    Route::get('/fertilizer-licenses/{fertilizer_license}/edit', [ShopFertilizerLicenseController::class, 'edit'])->name('fertilizer-licenses.edit');
    Route::put('/fertilizer-licenses/{fertilizer_license}', [ShopFertilizerLicenseController::class, 'update'])->name('fertilizer-licenses.update');
    Route::post('/notifications/read-all', [ShopNotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::post('/notifications/{notification}/read', [ShopNotificationController::class, 'read'])->name('notifications.read');
    Route::get('pesticide-shops/{shop}/download-license', [AdminPesticideShopController::class, 'downloadLicense'])->name('licenseDownload');
});

Route::middleware(['auth', 'role:farmer'])->prefix('farmer')->name('farmer.')->group(function () {
    Route::get('/dashboard', [FarmerDashboardController::class, 'index'])->name('dashboard');

    Route::middleware('feature:farmer_inquiries')->group(function () {
        Route::resource('inquiries', FarmerInquiryController::class)->only(['index', 'create', 'store', 'show']);
    });

    Route::post('notifications/read-all', [FarmerNotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::post('notifications/{notification}/read', [FarmerNotificationController::class, 'read'])->name('notifications.read');
});

Route::middleware(['auth', 'role:admin,staff'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::post('notifications/read-all', [NotificationController::class, 'readAll'])->name('notifications.read-all');
    Route::post('notifications/{notification}/read', [NotificationController::class, 'read'])->name('notifications.read');

    Route::middleware('feature:staff_management')->group(function () {
        Route::resource('staff', StaffController::class);
    });

    Route::middleware('feature:shop_inspections')->group(function () {
        Route::resource('pesticide-shop-inspections', PesticideShopInspectionController::class);
    });

    Route::middleware('feature:farmer_inquiries')->group(function () {
        Route::resource('inquiries', AgriculturalInquiryController::class)->only(['index', 'show', 'update']);
    });

    Route::get('fertilizer-licenses', [AdminFertilizerLicenseController::class, 'index'])->name('fertilizer-licenses.index');
    Route::get('fertilizer-licenses/{fertilizer_license}', [AdminFertilizerLicenseController::class, 'show'])->name('fertilizer-licenses.show');
    Route::get('fertilizer-licenses/{fertilizer_license}/generate', [AdminFertilizerLicenseController::class, 'generateDocx'])->name('fertilizer-licenses.generate');
    Route::put('fertilizer-licenses/{fertilizer_license}/status', [AdminFertilizerLicenseController::class, 'updateStatus'])->name('fertilizer-licenses.update_status');

    Route::resource('announcements', AgriculturalAnnouncementController::class)->except(['show']);

    Route::middleware('feature:shop_registration')->group(function () {
        Route::put('pesticide-shops/{shop}/update-status', [AdminPesticideShopController::class, 'update_status'])
            ->name('pesticide-shops.update_status');
        Route::resource('pesticide-shops', AdminPesticideShopController::class)->only(['index', 'show']);
        Route::get('pesticide-shops/{shop}/download-agreements', [AdminPesticideShopController::class, 'downloadSurroundingAgreements'])->name('pesticide-shops.download_agreements');
        Route::get('pesticide-shops/{id}/download', [AdminPesticideShopController::class, 'downloadDocument'])->name('pesticide-shops.download');
        Route::get('pesticide-shops/{shop}/download-license', [AdminPesticideShopController::class, 'downloadLicense'])->name('pesticide-shops.download_license');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('feature-settings', [FeatureSettingController::class, 'edit'])->name('feature-settings.edit');
        Route::put('feature-settings', [FeatureSettingController::class, 'update'])->name('feature-settings.update');

        Route::middleware('feature:landing_cms')->group(function () {
            Route::resource('landing-sections', LandingSectionController::class)->except(['show']);
        });
        Route::resource('categories', CategoryController::class)->except(['show']);

        Route::resource('users', UserController::class)->except(['show']);
    });
});

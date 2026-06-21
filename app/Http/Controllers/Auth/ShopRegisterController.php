<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\StoreShopRegistrationRequest;
use App\Models\PesticideShop;
use App\Models\User;
use App\Notifications\NewShopRegistrationNotification;
use App\Support\Feature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Notification;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ShopRegisterController extends Controller
{
    public function create(): View
    {
        // abort_unless(Feature::enabled('shop_registration'), 404);

        return view('auth.shop-register');
    }

    public function store(StoreShopRegistrationRequest $request): RedirectResponse
    {
        $user = User::create([
            'name' => $request->string('name'),
            'email' => $request->string('email'),
            'password' => $request->string('password'),
            'role' => User::ROLE_SHOP,
            'email_verified_at' => now(),
        ]);

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('shop.dashboard');
        // abort_unless(Feature::enabled('shop_registration'), 404);

        // $shop = PesticideShop::create([
        //     ...$request->safe()->only([
        //         'shop_name',
        //         'owner_name',
        //         'license_number',
        //         'phone',
        //         'email',
        //         'address',
        //         'township',
        //         'region',
        //     ]),
        //     'status' => PesticideShop::STATUS_PENDING,
        // ]);

        // $backOfficeUsers = User::query()
        //     ->whereIn('role', [User::ROLE_ADMIN, User::ROLE_STAFF])
        //     ->get();

        // Notification::send($backOfficeUsers, new NewShopRegistrationNotification($shop));

        // return redirect()
        //     ->route('shop.register')
        //     ->with('success', __('messages.flash.shop_registration_submitted'));
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        return redirect()->intended($this->redirectPathFor(Auth::user()));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('landing.home');
    }

    private function redirectPathFor(User $user): string
    {
        if ($user->isShop()) {
            return route('shop.dashboard', absolute: false);
        }

        if ($user->isFarmer()) {
            return route('farmer.dashboard', absolute: false);
        }

        if ($user->isBackOffice()) {
            return route('admin.dashboard.index', absolute: false);
        }

        return route('landing.home', absolute: false);
    }
}

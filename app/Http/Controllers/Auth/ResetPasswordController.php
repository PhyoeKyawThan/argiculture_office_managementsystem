<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ResetPasswordRequest;
use App\Models\PasswordResetToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ResetPasswordController extends Controller
{
    public function create(): View
    {
        return view('auth.reset-password');
    }

    public function store(ResetPasswordRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $user = \App\Models\User::where('email', $data['email'])->firstOrFail();
        $user->password = Hash::make($data['password']);
        $user->save();

        PasswordResetToken::where('email', $data['email'])->delete();

        return redirect()->route('login')
            ->with('status', __('messages.auth.password_reset_success'));
    }
}

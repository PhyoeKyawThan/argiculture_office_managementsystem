<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Mail\OtpMail;
use App\Models\PasswordResetToken;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    public function store(ForgotPasswordRequest $request): RedirectResponse
    {
        $email = $request->validated()['email'];

        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        PasswordResetToken::updateOrCreate(
            ['email' => $email],
            ['token' => $otp, 'created_at' => now()]
        );

        Mail::to($email)->send(new OtpMail($otp));

        return redirect()->route('password.reset', ['email' => $email])
            ->with('status', __('messages.auth.otp_sent'));
    }
}

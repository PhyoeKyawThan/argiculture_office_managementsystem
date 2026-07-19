<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'exists:users,email'],
            'otp' => ['required', 'string', 'size:6'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    protected function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $email = $this->input('email');
            $otp = $this->input('otp');

            $record = \App\Models\PasswordResetToken::where('email', $email)->first();

            if (! $record || ! hash_equals((string) $record->token, (string) $otp)) {
                $validator->errors()->add('otp', __('messages.auth.invalid_otp'));
            } elseif ($record->created_at && $record->created_at->lt(now()->subMinutes(15))) {
                $validator->errors()->add('otp', __('messages.auth.invalid_otp'));
            }
        });
    }
}

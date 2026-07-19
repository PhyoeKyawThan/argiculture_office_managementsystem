<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ __('messages.auth.reset_password_title') }}</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f3f4f6; padding: 40px 20px;">
    <table width="100%" cellpadding="0" cellspacing="0" style="max-width: 480px; margin: 0 auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; border: 1px solid #e5e7eb;">
        <tr>
            <td style="padding: 32px 24px; text-align: center; background-color: #064e3b;">
                <h1 style="color: #ffffff; font-size: 20px; margin: 0;">{{ config('app.name', 'AgriManage') }}</h1>
            </td>
        </tr>
        <tr>
            <td style="padding: 32px 24px;">
                <p style="color: #374151; font-size: 14px; line-height: 1.6;">{{ __('messages.auth.forgot_password_subtitle') }}</p>
                <p style="color: #374151; font-size: 14px; line-height: 1.6;">{{ __('messages.auth.otp') }}:</p>
                <div style="background-color: #ecfdf5; border: 1px dashed #059669; border-radius: 8px; padding: 16px; text-align: center; margin: 16px 0;">
                    <span style="font-size: 28px; font-weight: bold; letter-spacing: 6px; color: #064e3b;">{{ $otp }}</span>
                </div>
                <p style="color: #6b7280; font-size: 12px; line-height: 1.5;">{{ __('messages.auth.forgot_password_title') }}</p>
            </td>
        </tr>
    </table>
</body>
</html>

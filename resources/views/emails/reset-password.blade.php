@component('mail::message')
    {{-- Header with Logo --}}
    <div style="text-align: center; margin-bottom: 40px;">
        <table cellpadding="0" cellspacing="0" border="0" width="100%">
            <tr>
                <td align="center">
                    <div
                        style="display: inline-block; background: #000000; padding: 30px 40px; border-radius: 16px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3); margin-bottom: 20px;">
                        <img src="{{ asset('assets/logos/logo_header.png') }}" alt="Shonen Street"
                            style="max-width: 300px; width: 100%; height: auto; display: block; object-fit: contain;" />
                    </div>
                </td>
            </tr>
        </table>
    </div>

    {{-- Greeting --}}
    # Hello {{ $user->name }}!

    We received a request to reset your password for your **Shonen Street** account.

    {{-- Reset Button --}}
    @component('mail::button', ['url' => $url, 'color' => 'primary'])
        Reset Password
    @endcomponent

    {{-- Security Information --}}
    <div
        style="background-color: #f8f9fa; border-left: 4px solid #667eea; padding: 15px; margin: 25px 0; border-radius: 4px;">
        <p style="margin: 0; color: #495057; font-size: 14px;">
            <strong>🔒 Security Tip:</strong> This password reset link will expire in <strong>60 minutes</strong> for your
            security.
        </p>
    </div>

    If you didn't request a password reset, no further action is required. Your account is safe and secure.

    {{-- Alternative Link --}}
    <div style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef;">
        <p style="color: #6c757d; font-size: 13px; margin-bottom: 10px;">
            If you're having trouble clicking the "Reset Password" button, copy and paste the URL below into your web
            browser:
        </p>
        <p style="word-break: break-all; color: #667eea; font-size: 12px;">
            {{ $url }}
        </p>
    </div>

    {{-- Footer --}}
    <div style="text-align: center; margin-top: 40px; padding-top: 20px; border-top: 2px solid #e9ecef;">
        <p style="color: #6c757d; font-size: 13px; margin-bottom: 5px;">
            Thank you for being part of the Shonen Street community!
        </p>
        <p style="color: #adb5bd; font-size: 12px; margin: 0;">
            © {{ date('Y') }} Shonen Street. All rights reserved.
        </p>
    </div>
@endcomponent

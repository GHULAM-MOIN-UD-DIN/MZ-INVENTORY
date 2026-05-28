<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verification Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #020617; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #f8fafc;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 40px auto; background-color: #0f172a; border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.05); overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);">
        <!-- Header -->
        <tr>
            <td align="center" style="padding: 40px 40px 20px 40px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="width: 56px; height: 56px; background: rgba(249, 115, 22, 0.1); border-radius: 16px; font-size: 24px; color: #f97316; line-height: 56px; font-weight: 800;">
                            🔐
                        </td>
                    </tr>
                </table>
                <h1 style="font-size: 24px; font-weight: 800; color: #ffffff; margin: 20px 0 10px 0; letter-spacing: -0.025em;">
                    {{ $type === 'forgot_password' ? 'Reset Password' : '2-Step Verification' }}
                </h1>
                <p style="font-size: 14px; color: #f97316; margin: 0; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">
                    Verification Code
                </p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 20px 40px 40px 40px;">
                <p style="font-size: 15px; color: #e2e8f0; line-height: 1.6; margin: 0 0 20px 0; text-align: center;">
                    Please use the following 6-digit verification code to complete your request.
                </p>

                <!-- OTP Code Panel -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #1e293b; border-radius: 16px; margin: 24px 0; border: 1px solid rgba(255, 255, 255, 0.03);">
                    <tr>
                        <td align="center" style="padding: 30px;">
                            <div style="font-size: 36px; font-weight: 800; letter-spacing: 8px; color: #f97316; font-family: 'Courier New', Courier, monospace;">
                                {{ $otpCode }}
                            </div>
                        </td>
                    </tr>
                </table>

                <p style="font-size: 14px; color: #94a3b8; line-height: 1.6; margin: 0 0 24px 0; text-align: center;">
                    This code is valid for <strong>{{ $expiresInMinutes }} minutes</strong>. If you did not make this request, please ignore this email or change your password immediately.
                </p>

                <!-- Security warning -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: rgba(239, 68, 68, 0.05); border-radius: 16px; border: 1px solid rgba(239, 68, 68, 0.1); margin-bottom: 20px;">
                    <tr>
                        <td style="padding: 16px 20px; font-size: 13px; color: #fca5a5; line-height: 1.5; text-align: center;">
                            <strong>Never share your code.</strong> The MZ support team will never call or message you to ask for this code.
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center" style="padding: 30px 40px; background-color: #090d16; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                <p style="font-size: 10px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.15em; margin: 0 0 8px 0;">
                    &copy; 2026 MZ Inventory Pro
                </p>
                <p style="font-size: 10px; color: #475569; margin: 0;">
                    This is an automated security message.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Security Alert: New Login</title>
</head>
<body style="margin: 0; padding: 0; background-color: #020617; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #f8fafc;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 40px auto; background-color: #0f172a; border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.05); overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);">
        <!-- Header -->
        <tr>
            <td align="center" style="padding: 40px 40px 20px 40px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="width: 56px; height: 56px; background: rgba(249, 115, 22, 0.1); border-radius: 16px; font-size: 24px; color: #f97316; line-height: 56px;">
                            <span style="font-weight: 800;">⚠</span>
                        </td>
                    </tr>
                </table>
                <h1 style="font-size: 24px; font-weight: 800; color: #ffffff; margin: 20px 0 10px 0; tracking: -0.025em;">Security Login Alert</h1>
                <p style="font-size: 14px; color: #f97316; margin: 0; font-weight: 700; uppercase; tracking: 0.05em;">New Access Detected</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 20px 40px 40px 40px;">
                <p style="font-size: 15px; color: #e2e8f0; line-height: 1.6; margin: 0 0 20px 0;">
                    Hello <strong>{{ $user->name }}</strong>,
                </p>
                <p style="font-size: 14px; color: #94a3b8; line-height: 1.6; margin: 0 0 24px 0;">
                    This is an automated security notification to alert you that your account was recently accessed from a new session. Please verify the login details below:
                </p>

                <!-- Session details card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #1e293b; border-radius: 16px; margin-bottom: 28px; border: 1px solid rgba(255, 255, 255, 0.03);">
                    <tr>
                        <td style="padding: 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="35%" style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; padding-bottom: 12px;">Account</td>
                                    <td style="font-size: 13px; color: #f8fafc; font-weight: 600; padding-bottom: 12px;">{{ $user->email }} ({{ ucfirst($user->role) }})</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; padding-bottom: 12px;">Date & Time</td>
                                    <td style="font-size: 13px; color: #f8fafc; font-weight: 600; padding-bottom: 12px;">{{ $time }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; padding-bottom: 12px;">IP Address</td>
                                    <td style="font-size: 13px; color: #f8fafc; font-weight: 600; padding-bottom: 12px;">{{ $ip }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Device/Browser</td>
                                    <td style="font-size: 13px; color: #94a3b8; font-weight: 500; font-family: monospace;">{{ $userAgent }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Security warning -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: rgba(239, 68, 68, 0.05); border-radius: 16px; border: 1px solid rgba(239, 68, 68, 0.1); margin-bottom: 32px;">
                    <tr>
                        <td style="padding: 16px 20px; font-size: 13px; color: #fca5a5; line-height: 1.5;">
                            <strong>Didn't authorize this?</strong> If you do not recognize this login, your account password may be compromised. Please reset your password immediately or contact your administrator to freeze your account.
                        </td>
                    </tr>
                </table>

                <!-- Action Button -->
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="background: #ef4444; border-radius: 12px; box-shadow: 0 4px 12px rgba(239, 68, 68, 0.2);">
                            <a href="{{ url('/settings') }}" target="_blank" style="display: inline-block; padding: 12px 28px; font-size: 13px; font-weight: 700; color: #ffffff; text-decoration: none;">
                                Reset Password &rarr;
                            </a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center" style="padding: 30px 40px; background-color: #090d16; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                <p style="font-size: 10px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.15em; margin: 0 0 8px 0;">
                    &copy; 2026 {{ $user->shop_name ?? 'MZ Inventory Pro' }}
                </p>
                <p style="font-size: 10px; color: #475569; margin: 0;">
                    This is a security alert. Replies to this email are not monitored.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

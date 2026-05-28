<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to the Team</title>
</head>
<body style="margin: 0; padding: 0; background-color: #020617; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #f8fafc;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 40px auto; background-color: #0f172a; border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.05); overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);">
        <!-- Header -->
        <tr>
            <td align="center" style="padding: 40px 40px 20px 40px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="width: 56px; height: 56px; background: linear-gradient(135deg, #ea580c, #f97316); border-radius: 16px; font-weight: 800; font-size: 24px; color: #ffffff; line-height: 56px; text-shadow: 0 2px 4px rgba(0,0,0,0.2);">
                            MZ
                        </td>
                    </tr>
                </table>
                <h1 style="font-size: 24px; font-weight: 800; color: #ffffff; margin: 20px 0 10px 0; tracking: -0.025em;">Welcome to the Team!</h1>
                <p style="font-size: 14px; color: #94a3b8; margin: 0; line-height: 1.5;">Your staff account has been successfully created.</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 20px 40px 40px 40px;">
                <p style="font-size: 15px; color: #e2e8f0; line-height: 1.6; margin: 0 0 20px 0;">
                    Hello <strong>{{ $user->name }}</strong>,
                </p>
                <p style="font-size: 14px; color: #94a3b8; line-height: 1.6; margin: 0 0 24px 0;">
                    An Administrator has registered you as a <strong>{{ ucfirst($user->role) }}</strong> in the **{{ $user->shop_name ?? 'MZ Inventory Pro' }}** system. Here are your secure credentials to log in:
                </p>

                <!-- Credentials Card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #1e293b; border-radius: 16px; margin-bottom: 28px; border: 1px solid rgba(255, 255, 255, 0.03);">
                    <tr>
                        <td style="padding: 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="30%" style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; padding-bottom: 12px;">Login URL</td>
                                    <td style="font-size: 13px; color: #f8fafc; font-weight: 600; padding-bottom: 12px;">
                                        <a href="{{ url('/login') }}" style="color: #f97316; text-decoration: none;">{{ url('/login') }}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase; padding-bottom: 12px;">Email Address</td>
                                    <td style="font-size: 13px; color: #f8fafc; font-weight: 600; padding-bottom: 12px;">{{ $user->email }}</td>
                                </tr>
                                <tr>
                                    <td style="font-size: 12px; color: #64748b; font-weight: 700; text-transform: uppercase;">Password</td>
                                    <td style="font-size: 13px; color: #fdba74; font-family: monospace; font-weight: 700;">{{ $password }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Action Button -->
                <table align="center" border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 32px;">
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #f97316, #ea580c); border-radius: 12px; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);">
                            <a href="{{ url('/login') }}" target="_blank" style="display: inline-block; padding: 14px 32px; font-size: 14px; font-weight: 700; color: #ffffff; text-decoration: none;">
                                Access Portal &rarr;
                            </a>
                        </td>
                    </tr>
                </table>

                <!-- Security Note -->
                <p style="font-size: 12px; color: #64748b; line-height: 1.5; margin: 0; text-align: center;">
                    <strong>Security Notice:</strong> Please log in and change your password immediately in your account settings. Never share your credentials with anyone.
                </p>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center" style="padding: 30px 40px; background-color: #090d16; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                <p style="font-size: 10px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.15em; margin: 0 0 8px 0;">
                    &copy; 2026 {{ $user->shop_name ?? 'MZ Inventory Pro' }}
                </p>
                <p style="font-size: 10px; color: #475569; margin: 0;">
                    Secure inventory systems. All rights reserved.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

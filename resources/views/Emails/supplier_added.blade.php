<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Supplier Registered</title>
</head>
<body style="margin: 0; padding: 0; background-color: #020617; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #f8fafc;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 40px auto; background-color: #0f172a; border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.05); overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);">
        <!-- Header -->
        <tr>
            <td align="center" style="padding: 40px 40px 20px 40px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="width: 56px; height: 56px; background: rgba(249, 115, 22, 0.1); border-radius: 16px; font-size: 24px; color: #f97316; line-height: 56px;">
                            🤝
                        </td>
                    </tr>
                </table>
                <h1 style="font-size: 24px; font-weight: 800; color: #ffffff; margin: 20px 0 10px 0; tracking: -0.025em;">New Supplier Registered</h1>
                <p style="font-size: 14px; color: #94a3b8; margin: 0; line-height: 1.5;">A new supply partner was registered in the database.</p>
            </td>
        </tr>

        <!-- Content -->
        <tr>
            <td style="padding: 20px 40px 40px 40px;">
                <p style="font-size: 15px; color: #e2e8f0; line-height: 1.6; margin: 0 0 20px 0;">
                    Hello team,
                </p>
                <p style="font-size: 14px; color: #94a3b8; line-height: 1.6; margin: 0 0 24px 0;">
                    This is to inform you that <strong>{{ $actor->name }}</strong> has registered a new supplier in the system. The supply partner details are listed below:
                </p>

                <!-- Supplier details card -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #1e293b; border-radius: 16px; margin-bottom: 28px; border: 1px solid rgba(255, 255, 255, 0.03); overflow: hidden;">
                    <tr style="background-color: #0f172a;">
                        <td style="padding: 16px 24px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                            <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 4px 0; tracking-widest: 0.1em;">Supplier Name/Company</p>
                            <h2 style="font-size: 18px; font-weight: 800; color: #ffffff; margin: 0;">{{ $supplier->name }}</h2>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 24px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="50%" style="padding-bottom: 16px; vertical-align: top;">
                                        <p style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 4px 0;">Email</p>
                                        <p style="font-size: 13px; color: #f8fafc; font-weight: 600; margin: 0;">{{ $supplier->email ?? 'N/A' }}</p>
                                    </td>
                                    <td width="50%" style="padding-bottom: 16px; vertical-align: top;">
                                        <p style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 4px 0;">Phone</p>
                                        <p style="font-size: 13px; color: #f8fafc; font-weight: 600; margin: 0;">{{ $supplier->phone ?? 'N/A' }}</p>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2" style="border-top: 1px solid rgba(255, 255, 255, 0.05); padding-top: 16px; vertical-align: top;">
                                        <p style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 4px 0;">Address</p>
                                        <p style="font-size: 13px; color: #94a3b8; line-height: 1.5; margin: 0;">{{ $supplier->address ?? 'N/A' }}</p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

                <!-- Action Button -->
                <table align="center" border="0" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" style="background: linear-gradient(135deg, #f97316, #ea580c); border-radius: 12px; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);">
                            <a href="{{ url('/people/suppliers') }}" target="_blank" style="display: inline-block; padding: 13px 30px; font-size: 13px; font-weight: 700; color: #ffffff; text-decoration: none;">
                                View Suppliers &rarr;
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
                    &copy; 2026 {{ $actor->shop_name ?? 'MZ Inventory Pro' }}
                </p>
                <p style="font-size: 10px; color: #475569; margin: 0;">
                    Secure inventory systems. All rights reserved.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

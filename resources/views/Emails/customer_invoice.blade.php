<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Digital Invoice</title>
</head>
<body style="margin: 0; padding: 0; background-color: #020617; font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif; color: #f8fafc;">
    <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 40px auto; background-color: #0f172a; border-radius: 24px; border: 1px solid rgba(255, 255, 255, 0.05); overflow: hidden; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5);">
        <!-- Header -->
        <tr>
            <td style="padding: 40px 40px 20px 40px; border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td>
                            <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #ea580c, #f97316); border-radius: 12px; font-weight: 800; font-size: 20px; color: #ffffff; line-height: 48px; text-align: center; margin-bottom: 16px;">
                                MZ
                            </div>
                            <h1 style="font-size: 20px; font-weight: 800; color: #ffffff; margin: 0;">{{ $shopName }}</h1>
                            <p style="font-size: 11px; text-transform: uppercase; tracking: 0.1em; color: #f97316; font-weight: 700; margin: 4px 0 0 0;">Digital Checkout Invoice</p>
                        </td>
                        <td align="right" style="vertical-align: bottom;">
                            <p style="font-size: 11px; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 4px 0;">Invoice Number</p>
                            <p style="font-size: 16px; font-weight: 800; color: #ffffff; margin: 0; font-family: monospace;">#{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</p>
                            <p style="font-size: 11px; color: #94a3b8; margin: 4px 0 0 0;">{{ $sale->created_at->format('M d, Y h:i A') }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Billing Info -->
        <tr>
            <td style="padding: 24px 40px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="50%" style="vertical-align: top;">
                            <p style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 6px 0;">Billed To</p>
                            <p style="font-size: 13px; font-weight: 700; color: #ffffff; margin: 0;">{{ $sale->customer->name ?? 'Walk-in Customer' }}</p>
                            @if($sale->customer && $sale->customer->phone)
                                <p style="font-size: 12px; color: #94a3b8; margin: 2px 0 0 0;">{{ $sale->customer->phone }}</p>
                            @endif
                        </td>
                        <td width="50%" align="right" style="vertical-align: top;">
                            <p style="font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase; margin: 0 0 6px 0;">Issued By</p>
                            <p style="font-size: 13px; font-weight: 700; color: #ffffff; margin: 0;">{{ $shopName }}</p>
                            <p style="font-size: 11px; color: #94a3b8; margin: 2px 0 0 0;">Support: {{ $adminEmail }}</p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Table Items -->
        <tr>
            <td style="padding: 0 40px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(255, 255, 255, 0.05); background-color: rgba(255, 255, 255, 0.02);">
                            <th align="left" style="padding: 12px 16px; font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase;">Product Item</th>
                            <th align="center" style="padding: 12px 16px; font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase;">Qty</th>
                            <th align="right" style="padding: 12px 16px; font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase;">Unit Price</th>
                            <th align="right" style="padding: 12px 16px; font-size: 10px; font-weight: 700; color: #64748b; text-transform: uppercase;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody style="border-bottom: 1px solid rgba(255, 255, 255, 0.05);">
                        @foreach($sale->items as $item)
                        <tr style="border-bottom: 1px solid rgba(255, 255, 255, 0.02);">
                            <td style="padding: 16px; font-size: 13px; color: #ffffff; font-weight: 600;">
                                {{ $item->product->name ?? 'Deleted Product' }}
                                <p style="font-size: 10px; color: #64748b; margin: 2px 0 0 0; font-family: monospace;">{{ $item->product->code ?? '' }}</p>
                            </td>
                            <td align="center" style="padding: 16px; font-size: 13px; color: #f8fafc; font-weight: 600;">{{ $item->quantity }}</td>
                            <td align="right" style="padding: 16px; font-size: 13px; color: #94a3b8;">Rs. {{ number_format($item->unit_price, 2) }}</td>
                            <td align="right" style="padding: 16px; font-size: 13px; color: #ffffff; font-weight: 700;">Rs. {{ number_format($item->subtotal, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </td>
        </tr>

        <!-- Summary Totals -->
        <tr>
            <td style="padding: 24px 40px 40px 40px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="55%">
                            <p style="font-size: 13px; color: #94a3b8; line-height: 1.5; margin: 0;">
                                Thank you for shopping at <strong>{{ $shopName }}</strong>! We appreciate your business and hope to see you again soon.
                            </p>
                        </td>
                        <td width="45%" align="right" style="vertical-align: top;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="right" style="font-size: 12px; color: #64748b; padding-bottom: 8px;">Subtotal</td>
                                    <td align="right" style="font-size: 12px; color: #f8fafc; font-weight: 600; padding-bottom: 8px;">Rs. {{ number_format($sale->total, 2) }}</td>
                                </tr>
                                @if($sale->tax > 0)
                                <tr>
                                    <td align="right" style="font-size: 12px; color: #64748b; padding-bottom: 8px;">Tax ({{ $sale->tax_percentage ?? 0 }}%)</td>
                                    <td align="right" style="font-size: 12px; color: #fca5a5; font-weight: 600; padding-bottom: 8px;">+ Rs. {{ number_format($sale->tax, 2) }}</td>
                                </tr>
                                @endif
                                @if($sale->discount > 0)
                                <tr>
                                    <td align="right" style="font-size: 12px; color: #64748b; padding-bottom: 8px;">Discount</td>
                                    <td align="right" style="font-size: 12px; color: #86efac; font-weight: 600; padding-bottom: 8px;">- Rs. {{ number_format($sale->discount, 2) }}</td>
                                </tr>
                                @endif
                                <tr style="border-top: 1px solid rgba(255, 255, 255, 0.05);">
                                    <td align="right" style="font-size: 14px; font-weight: 800; color: #ffffff; padding-top: 12px;">Total Paid</td>
                                    <td align="right" style="font-size: 16px; font-weight: 900; color: #f97316; padding-top: 12px;">Rs. {{ number_format($sale->grand_total, 2) }}</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer -->
        <tr>
            <td align="center" style="padding: 30px 40px; background-color: #090d16; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                <p style="font-size: 10px; font-weight: 700; color: #475569; text-transform: uppercase; letter-spacing: 0.15em; margin: 0 0 8px 0;">
                    &copy; 2026 {{ $shopName }}
                </p>
                <p style="font-size: 10px; color: #475569; margin: 0;">
                    Automated billing engines. Powered by MZ Inventory Pro.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>

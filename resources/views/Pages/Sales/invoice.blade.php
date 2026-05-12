<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice #{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</title>
    <style>
        @page { size: 80mm 200mm; margin: 0; }
        body { 
            font-family: 'Courier New', Courier, monospace; 
            width: 70mm; 
            margin: 0 auto; 
            padding: 5mm; 
            font-size: 12px; 
            line-height: 1.4;
            color: #000;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .bold { font-weight: bold; }
        .header { margin-bottom: 5mm; border-bottom: 1px dashed #000; padding-bottom: 2mm; }
        .store-name { font-size: 16px; font-weight: bold; text-transform: uppercase; }
        .details { margin-bottom: 3mm; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 3mm; }
        th { text-align: left; border-bottom: 1px dashed #000; padding: 1mm 0; font-size: 10px; }
        td { padding: 1mm 0; vertical-align: top; font-size: 10px; }
        .totals { border-top: 1px dashed #000; padding-top: 2mm; }
        .total-row { display: flex; justify-content: space-between; margin-bottom: 1mm; }
        .footer { margin-top: 5mm; border-top: 1px dashed #000; padding-top: 2mm; font-size: 9px; }
        .barcode { margin-top: 3mm; }
        .no-print { 
            margin-bottom: 5mm; 
            padding: 10px; 
            background: #f97316; 
            color: white; 
            text-decoration: none; 
            display: inline-block; 
            border-radius: 5px; 
            font-family: sans-serif;
            font-weight: bold;
            font-size: 12px;
        }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body onload="window.print()">
    <div class="text-center no-print">
        <a href="{{ route('sale.download', $sale->id) }}" class="no-print">Download PDF</a>
    </div>

    <div class="header text-center">
        <div class="store-name">INVENTORY MS</div>
        <div class="details">
            Retail Management System<br>
            Phone: +92 300 1234567<br>
            Date: {{ $sale->created_at->format('d-M-Y H:i') }}
        </div>
    </div>

    <div class="details">
        <b>Inv #:</b> {{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}<br>
        <b>Cust:</b> {{ $sale->customer->name ?? 'Walk-in' }}<br>
        <b>Pay:</b> {{ $sale->payment_method ?? 'Cash' }}
    </div>

    <table>
        <thead>
            <tr>
                <th>Item</th>
                <th class="text-center">Qty</th>
                <th class="text-right">Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach($sale->items as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ number_format($item->subtotal, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals">
        <div class="total-row">
            <span>Bill Amount:</span>
            <span>Rs. {{ number_format($sale->items->sum('subtotal'), 2) }}</span>
        </div>
        @if($sale->discount > 0)
        <div class="total-row">
            <span>Discount:</span>
            <span>-Rs. {{ number_format($sale->discount, 2) }}</span>
        </div>
        @endif
        <div class="total-row">
            <span>Service Charge:</span>
            <span>Rs. {{ number_format($sale->service_charge ?? 1, 2) }}</span>
        </div>
        
        <div class="total-row bold" style="font-size: 14px; margin-top: 2mm; border-top: 1px solid #000; padding-top: 1mm;">
            <span>TOTAL PAYABLE:</span>
            <span>Rs. {{ number_format($sale->grand_total, 2) }}</span>
        </div>
        
        <div style="margin-top: 4mm; border: 1px dashed #000; padding: 2mm;">
            <div class="total-row">
                <span>CASH PAID:</span>
                <span>Rs. {{ number_format($sale->cash_received, 2) }}</span>
            </div>
            <div class="total-row bold" style="color: #000;">
                <span>BALANCE RETURNED:</span>
                <span>Rs. {{ number_format($sale->change_return, 2) }}</span>
            </div>
        </div>
    </div>

    <div class="footer text-center">
        THANK YOU FOR SHOPPING!<br>
        Please visit again.<br>
        Software by Antigravity AI
    </div>
</body>
</html>

<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerInvoiceMail;

class POSController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $customers = Customer::all();
        
        $query = Product::with('category')->where('quantity', '>', 0);
        
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }
        
        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }
        
        $products = $query->paginate(12);
        
        return view('Pages.POS.index', compact('categories', 'customers', 'products'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'items' => 'required|array',
            'grand_total' => 'required|numeric'
        ]);

        $sale = DB::transaction(function() use ($request) {
            $ref = 'POS-' . strtoupper(uniqid());
            
            $sale = Sale::create([
                'reference' => $ref,
                'customer_id' => $request->customer_id,
                'date' => now(),
                'status' => 'Completed',
                'payment_status' => $request->payment_status ?? 'Paid',
                'grand_total' => $request->grand_total,
                'cash_received' => $request->cash_received ?? 0,
                'change_return' => $request->change_return ?? 0,
                'service_charge' => 1.00, // Fixed 1 Rupee service charge
                'discount' => $request->discount ?? 0,
                'tax' => $request->tax ?? 0,
                'payment_method' => $request->payment_method ?? 'Cash',
                'note' => $request->note
            ]);

            foreach ($request->items as $item) {
                SaleItem::create([
                    'sale_id' => $sale->id,
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['qty'] * $item['price']
                ]);

                // Update Stock
                $product = Product::find($item['id']);
                if ($product) {
                    $product->decrement('quantity', $item['qty']);
                }
            }

            return $sale;
        });

        // Send invoice email to customer if they have an email
        try {
            $sale->load(['customer', 'items.product']);
            if ($sale->customer && $sale->customer->email) {
                $actor = Auth::user();
                $adminId = $actor->admin_id ?? $actor->id;
                $admin = User::find($adminId);
                $shopName = $admin->shop_name ?? 'MZ Inventory Pro';
                $adminEmail = $admin->email ?? config('mail.from.address');

                Mail::to($sale->customer->email)->send(
                    new CustomerInvoiceMail($sale, $shopName, $adminEmail)
                );
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Customer invoice email failed: ' . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Sale completed successfully!',
            'sale_id' => $sale->id,
            'invoice_url' => route('sale.invoice', $sale->id)
        ]);
    }
}


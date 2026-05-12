<?php
namespace App\Http\Controllers\Sale;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Customer;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')->latest()->get();
        return view('Pages.Sales.List_Sale', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::all();
        return view('Pages.Sales.Add_Sale', compact('customers'));
    }

    public function store(Request $request)
    {
        $request->validate(['date' => 'required|date', 'status' => 'required', 'grand_total' => 'required']);
        $ref = 'INV-' . str_pad(Sale::count() + 1, 5, '0', STR_PAD_LEFT);
        
        $sale = Sale::create(array_merge($request->all(), ['reference' => $ref]));

        // Handle items if present (dynamic JS rows)
        if ($request->has('products')) {
            foreach ($request->products as $item) {
                $sale->items()->create([
                    'product_id' => $item['id'],
                    'quantity' => $item['qty'],
                    'unit_price' => $item['price'],
                    'subtotal' => $item['qty'] * $item['price'],
                ]);
                
                // Deduct Inventory
                $product = \App\Models\Product::find($item['id']);
                if ($product) {
                    $product->decrement('quantity', $item['qty']);
                }
            }
        }

        return redirect()->route('sale.index')->with('success', 'Sale created successfully!');
    }

    public function showInvoice($id)
    {
        $sale = Sale::with(['customer', 'items.product'])->findOrFail($id);
        return view('Pages.Sales.invoice', compact('sale'));
    }

    public function downloadInvoice($id)
    {
        $sale = Sale::with(['customer', 'items.product'])->findOrFail($id);
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('Pages.Sales.invoice', compact('sale'));
        return $pdf->download('Invoice-' . $sale->reference . '.pdf');
    }

    public function refund($id)
    {
        return DB::transaction(function() use ($id) {
            $sale = Sale::with('items')->findOrFail($id);
            
            if ($sale->status == 'Refunded') {
                return back()->with('error', 'This sale is already refunded.');
            }

            foreach ($sale->items as $item) {
                $product = \App\Models\Product::find($item->product_id);
                if ($product) {
                    $product->increment('quantity', $item->quantity);
                }
            }

            $sale->update(['status' => 'Refunded', 'payment_status' => 'Refunded']);

            return back()->with('success', 'Sale refunded and inventory restored!');
        });
    }

    public function destroy($id)
    {
        Sale::findOrFail($id)->delete();
        return redirect()->route('sale.index')->with('success', 'Sale deleted!');
    }
}

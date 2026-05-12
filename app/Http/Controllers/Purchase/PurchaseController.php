<?php
namespace App\Http\Controllers\Purchase;
use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Supplier;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::with('supplier')->latest()->get();
        return view('Pages.Purchases.List_Purchase', compact('purchases'));
    }

    public function create()
    {
        $suppliers = Supplier::all();
        return view('Pages.Purchases.Add_Purchase', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate(['date' => 'required|date', 'status' => 'required']);
        $ref = 'PUR-' . str_pad(Purchase::count() + 1, 5, '0', STR_PAD_LEFT);
        Purchase::create(array_merge($request->all(), ['reference' => $ref]));
        return redirect()->route('purchase.index')->with('success', 'Purchase created!');
    }

    public function destroy($id)
    {
        Purchase::findOrFail($id)->delete();
        return redirect()->route('purchase.index')->with('success', 'Purchase deleted!');
    }
}

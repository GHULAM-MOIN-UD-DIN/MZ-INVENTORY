<?php
namespace App\Http\Controllers\Returns;
use App\Http\Controllers\Controller;
use App\Models\SaleReturn;
use App\Models\Customer;
use App\Models\Supplier;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    public function index()
    {
        $returns = SaleReturn::with(['customer', 'supplier'])->latest()->get();
        return view('Pages.Returns.List_Returns', compact('returns'));
    }

    public function create()
    {
        $customers = Customer::all();
        $suppliers = Supplier::all();
        return view('Pages.Returns.Add_Return', compact('customers', 'suppliers'));
    }

    public function store(Request $request)
    {
        $request->validate(['date' => 'required|date', 'type' => 'required']);
        $ref = 'RET-' . str_pad(SaleReturn::count() + 1, 5, '0', STR_PAD_LEFT);
        SaleReturn::create(array_merge($request->all(), ['reference' => $ref]));
        return redirect()->route('return.index')->with('success', 'Return created!');
    }

    public function destroy($id)
    {
        SaleReturn::findOrFail($id)->delete();
        return redirect()->route('return.index')->with('success', 'Return deleted!');
    }
}

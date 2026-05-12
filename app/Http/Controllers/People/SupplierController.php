<?php
namespace App\Http\Controllers\People;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();
        return view('Pages.People.List_Suppliers', compact('suppliers'));
    }

    public function create() { return view('Pages.People.Add_Supplier'); }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Supplier::create($request->all());
        return redirect()->route('supplier.index')->with('success', 'Supplier added!');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('Pages.People.Edit_Supplier', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        Supplier::findOrFail($id)->update($request->all());
        return redirect()->route('supplier.index')->with('success', 'Supplier updated!');
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return redirect()->route('supplier.index')->with('success', 'Supplier deleted!');
    }
}

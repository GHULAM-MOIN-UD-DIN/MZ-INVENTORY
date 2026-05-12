<?php
namespace App\Http\Controllers\People;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('Pages.People.List_Customers', compact('customers'));
    }

    public function create()
    {
        return view('Pages.People.Add_Customer');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required']);
        Customer::create($request->all());
        return redirect()->route('customer.index')->with('success', 'Customer added!');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('Pages.People.Edit_Customer', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => 'required']);
        Customer::findOrFail($id)->update($request->all());
        return redirect()->route('customer.index')->with('success', 'Customer updated!');
    }

    public function destroy($id)
    {
        Customer::findOrFail($id)->delete();
        return redirect()->route('customer.index')->with('success', 'Customer deleted!');
    }
}

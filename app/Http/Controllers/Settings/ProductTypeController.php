<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductType;

class ProductTypeController extends Controller
{
    public function index()
    {
        $productTypes = ProductType::latest()->paginate(10);
        return view('Pages.Settings.ProductTypes.index', compact('productTypes'));
    }

    public function create()
    {
        return view('Pages.Settings.ProductTypes.create');
    }

    public function store(Request $request)
    {
        $userId = \Illuminate\Support\Facades\Auth::user()->admin_id ?? \Illuminate\Support\Facades\Auth::id();
        $request->validate([
            'name' => [
                'required',
                \Illuminate\Validation\Rule::unique('product_types')->where('user_id', $userId)
            ],
        ]);

        ProductType::create($request->all());
        return redirect()->route('product-type.index')->with('success', 'Product Type added successfully!');
    }

    public function edit($id)
    {
        $productType = ProductType::findOrFail($id);
        return view('Pages.Settings.ProductTypes.edit', compact('productType'));
    }

    public function update(Request $request, $id)
    {
        $productType = ProductType::findOrFail($id);
        $userId = \Illuminate\Support\Facades\Auth::user()->admin_id ?? \Illuminate\Support\Facades\Auth::id();
        $request->validate([
            'name' => [
                'required',
                \Illuminate\Validation\Rule::unique('product_types')->where('user_id', $userId)->ignore($productType->id)
            ],
        ]);

        $productType->update($request->all());
        return redirect()->route('product-type.index')->with('success', 'Product Type updated successfully!');
    }

    public function destroy($id)
    {
        $productType = ProductType::findOrFail($id);
        $productType->delete();
        return redirect()->route('product-type.index')->with('success', 'Product Type deleted successfully!');
    }
}

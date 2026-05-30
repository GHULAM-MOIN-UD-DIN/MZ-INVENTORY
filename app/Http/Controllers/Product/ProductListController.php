<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductListController extends Controller
{
    // ✅ Show Product List
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Product::with('category')->latest();

        if ($request->has('search') && $request->search != '') {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        $products = $query->paginate(10)->appends($request->all());
        $categories = \App\Models\Category::all();
        return view('Pages.Products.List_Product', compact('products', 'categories'));
    }
}

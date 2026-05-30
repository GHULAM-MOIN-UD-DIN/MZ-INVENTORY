<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ProductListController extends Controller
{
    // ✅ Show Product List
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        $categories = \App\Models\Category::all();
        return view('Pages.Products.List_Product', compact('products', 'categories'));
    }
}

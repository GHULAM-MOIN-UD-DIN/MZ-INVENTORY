<?php

namespace App\Http\Controllers\Categories;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category; // ✅ Import the Category model

class Categories_List_Controller extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(10);
        return view('Pages.Categories.List_Categories', compact('categories'));
    }
}

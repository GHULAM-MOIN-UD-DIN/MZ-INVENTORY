<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    // Show Add Product Form
    public function create()
    {
        $categories = Category::all();
        return view('Pages.Products.Add_Products', compact('categories'));
    }

    // Store Product
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'code' => 'required|unique:products',
            'barcode_symbology' => 'required',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $request->all();

        // Upload Image
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/' . $imageName;
        }

        Product::create($data);

        return redirect()->route('product.index')
            ->with('success','Product added successfully!');
    }

    // Show Edit Form
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('Pages.Products.Update_product', compact('product','categories'));
    }

    // Update Product
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'type' => 'required',
            'name' => 'required',
            'code' => 'required|unique:products,code,' . $product->id,
            'barcode_symbology' => 'required',
            'cost' => 'required|numeric',
            'price' => 'required|numeric',
            'quantity' => 'required|numeric',
            'category_id' => 'required|exists:categories,id'
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('uploads/products'), $imageName);
            $data['image'] = 'uploads/products/' . $imageName;
        }

        $product->update($data);

        return redirect()->route('product.index')
            ->with('success','Product updated successfully!');
    }

    // Delete Product
    public function destroy($id)
    {
        Product::findOrFail($id)->delete();
        return redirect()->route('product.index')->with('success', 'Product removed from inventory');
    }

    public function export()
    {
        $products = Product::all();
        $csvFileName = 'Inventory_Report_' . date('Y-m-d') . '.csv';
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$csvFileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $columns = ['Name', 'Code', 'Category', 'Cost (Rs.)', 'Price (Rs.)', 'Quantity'];

        $callback = function() use($products, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($products as $p) {
                fputcsv($file, [
                    $p->name,
                    $p->code,
                    $p->category->name ?? 'N/A',
                    $p->cost,
                    $p->price,
                    $p->quantity
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}

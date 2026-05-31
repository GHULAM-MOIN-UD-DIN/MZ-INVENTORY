<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class BarcodeController extends Controller
{
    /**
     * Public product page - accessible without login via QR code scan.
     * Does NOT show cost price, profit, or stock quantity.
     */
    public function publicView($code)
    {
        $product = Product::with('category')->where('code', $code)->first();

        if (!$product) {
            return view('Pages.Products.public_product', ['product' => null, 'code' => $code]);
        }

        return view('Pages.Products.public_product', compact('product'));
    }

    /**
     * Show product details when a barcode is scanned.
     * Looks up by product code.
     */
    public function scan($code)
    {
        $product = Product::with('category')->where('code', $code)->first();

        if (!$product) {
            return view('Pages.Products.barcode_scan_result', ['product' => null, 'code' => $code]);
        }

        return view('Pages.Products.barcode_scan_result', compact('product'));
    }

    /**
     * API endpoint for barcode lookup (used by POS scanner).
     */
    public function lookup(Request $request)
    {
        $code = $request->input('code');
        $product = Product::with('category')->where('code', $code)->first();

        if (!$product) {
            return response()->json(['found' => false, 'message' => 'Product not found']);
        }

        return response()->json([
            'found' => true,
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'code' => $product->code,
                'category' => $product->category->name ?? 'N/A',
                'cost' => $product->cost,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'image' => $product->image ? cloudinary_url($product->image) : null,
                'description' => $product->description,
                'type' => $product->type,
                'barcode_symbology' => $product->barcode_symbology,
                'tax_method' => $product->tax_method,
            ]
        ]);
    }
}

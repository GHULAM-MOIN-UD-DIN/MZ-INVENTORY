<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Purchase;
use App\Models\Expense;
use App\Models\Product;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        return view('Pages.Report');
    }

    public function profitLoss(Request $request)
    {
        $sales = Sale::sum('grand_total');
        $purchases = Purchase::sum('grand_total');
        $expenses = Expense::sum('amount');
        
        $gross_profit = $sales - $purchases;
        $net_profit = $gross_profit - $expenses;

        $recent_expenses = Expense::latest()->take(10)->get();

        return view('Pages.Reports.ProfitLoss', compact(
            'sales', 'purchases', 'expenses', 'gross_profit', 'net_profit', 'recent_expenses'
        ));
    }

    public function inventoryReport()
    {
        $products = Product::with('category')->get();
        $total_value = $products->sum(fn($p) => $p->quantity * $p->price);
        $low_stock_count = $products->where('quantity', '<=', 10)->count();

        return view('Pages.Reports.Inventory', compact('products', 'total_value', 'low_stock_count'));
    }
}

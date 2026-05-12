<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\Purchase;
use App\Models\SaleReturn;
use App\Models\Customer;
use App\Models\Supplier;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $total_sales = Sale::sum('grand_total');
        $total_purchases = Purchase::sum('grand_total');
        $total_customers = Customer::count();
        $total_suppliers = Supplier::count();
        $sales_count = Sale::count();
        $pending_sales = Sale::where('status', 'Pending')->count();
        $total_products = Product::count();
        
        // Net Profit Calculation (Sales - Purchases)
        $net_profit = $total_sales - $total_purchases;

        // Recent Activity (last 5 sales)
        $recent_sales = Sale::with('customer')->latest()->take(5)->get();
        
        // Latest Products
        $latest_products = Product::with('category')->latest()->take(5)->get();

        // Chart Data: Sales for the last 7 days
        $sales_data = Sale::selectRaw('CAST(created_at AS DATE) as date, SUM(grand_total) as total')
            ->where('created_at', '>=', now()->subDays(7))
            ->groupByRaw('CAST(created_at AS DATE)')
            ->orderByRaw('CAST(created_at AS DATE) ASC')
            ->get();
            
        $chart_labels = $sales_data->pluck('date');
        $chart_values = $sales_data->pluck('total');

        // Low Stock Alerts (quantity <= 10)
        $low_stock_products = Product::where('quantity', '<=', 10)->latest()->take(5)->get();

        return view('Pages.Dashboard', compact(
            'total_sales',
            'total_purchases',
            'total_customers',
            'total_suppliers',
            'sales_count',
            'pending_sales',
            'total_products',
            'recent_sales',
            'net_profit',
            'latest_products',
            'chart_labels',
            'chart_values',
            'low_stock_products'
        ));
    }
}

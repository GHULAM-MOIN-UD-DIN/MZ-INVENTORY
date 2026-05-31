<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register custom Brevo API mail driver
        try {
            \Illuminate\Support\Facades\Mail::extend('brevo-api', function (array $config) {
                return new \App\Mail\Transports\BrevoApiTransport(
                    $config['key'],
                    config('mail.from.address'),
                    config('mail.from.name')
                );
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to extend mailer with brevo-api driver: ' . $e->getMessage());
        }

        try {
            if (config('database.default') && \Illuminate\Support\Facades\Schema::hasTable('settings')) {
                \Illuminate\Support\Facades\View::share('settings', \App\Models\Setting::first());
            } else {
                \Illuminate\Support\Facades\View::share('settings', null);
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\View::share('settings', null);
        }

        // Notifications View Composer
        try {
            \Illuminate\Support\Facades\View::composer('Layout.index', function ($view) {
                if (\Illuminate\Support\Facades\Auth::check()) {
                    $dismissed = session('dismissed_notifications', []);
                    $notifications = [];

                    // 1. Low stock alerts (quantity <= 5)
                    if (\Illuminate\Support\Facades\Schema::hasTable('products')) {
                        $lowStockProducts = \App\Models\Product::where('quantity', '<=', 5)->get();
                        foreach ($lowStockProducts as $product) {
                            $id = 'low_stock_' . $product->id;
                            if (!in_array($id, $dismissed)) {
                                $notifications[] = [
                                    'id' => $id,
                                    'type' => 'low_stock',
                                    'title' => 'Low Stock Warning',
                                    'message' => '"' . $product->name . '" has only ' . $product->quantity . ' items left.',
                                    'url' => route('product.index') . '?search=' . urlencode($product->name),
                                    'icon' => 'fas fa-triangle-exclamation',
                                    'color' => 'text-orange-500 bg-orange-500/10 dark:bg-orange-500/20',
                                    'time' => 'Inventory Alert'
                                ];
                            }
                        }
                    }

                    // 2. Unpaid/Pending sales alerts (payment_status != 'Paid')
                    if (\Illuminate\Support\Facades\Schema::hasTable('sales')) {
                        $unpaidSales = \App\Models\Sale::where('payment_status', '!=', 'Paid')
                            ->latest()
                            ->take(10)
                            ->get();
                        foreach ($unpaidSales as $sale) {
                            $id = 'unpaid_sale_' . $sale->id;
                            if (!in_array($id, $dismissed)) {
                                $customerName = $sale->customer ? $sale->customer->name : 'Walk-in Customer';
                                $notifications[] = [
                                    'id' => $id,
                                    'type' => 'unpaid_sale',
                                    'title' => 'Unpaid Sale (' . $sale->payment_status . ')',
                                    'message' => 'Sale ' . $sale->reference . ' for ' . $customerName . ' is ' . strtolower($sale->payment_status) . '.',
                                    'url' => route('sale.index'),
                                    'icon' => 'fas fa-receipt',
                                    'color' => 'text-red-500 bg-red-500/10 dark:bg-red-500/20',
                                    'time' => $sale->created_at ? $sale->created_at->diffForHumans() : 'Recently'
                                ];
                            }
                        }
                    }

                    // 3. New Product Alerts (created in last 2 days)
                    if (\Illuminate\Support\Facades\Schema::hasTable('products')) {
                        $newProducts = \App\Models\Product::where('created_at', '>=', now()->subDays(2))
                            ->latest()
                            ->get();
                        foreach ($newProducts as $product) {
                            $id = 'new_product_' . $product->id;
                            if (!in_array($id, $dismissed)) {
                                $notifications[] = [
                                    'id' => $id,
                                    'type' => 'new_product',
                                    'title' => 'New Product Added',
                                    'message' => 'Product "' . $product->name . '" has been added to inventory.',
                                    'url' => route('product.index') . '?search=' . urlencode($product->name),
                                    'icon' => 'fas fa-box',
                                    'color' => 'text-green-500 bg-green-500/10 dark:bg-green-500/20',
                                    'time' => $product->created_at ? $product->created_at->diffForHumans() : 'Just now'
                                ];
                            }
                        }
                    }

                    // 4. New Sale Alerts (created in last 2 days)
                    if (\Illuminate\Support\Facades\Schema::hasTable('sales')) {
                        $newSales = \App\Models\Sale::where('created_at', '>=', now()->subDays(2))
                            ->where('payment_status', '=', 'Paid')
                            ->latest()
                            ->get();
                        foreach ($newSales as $sale) {
                            $id = 'new_sale_' . $sale->id;
                            if (!in_array($id, $dismissed)) {
                                $customerName = $sale->customer ? $sale->customer->name : 'Walk-in Customer';
                                $notifications[] = [
                                    'id' => $id,
                                    'type' => 'new_sale',
                                    'title' => 'New Sale Invoice',
                                    'message' => 'Sale ' . $sale->reference . ' for ' . $customerName . ' was completed.',
                                    'url' => route('sale.index'),
                                    'icon' => 'fas fa-shopping-cart',
                                    'color' => 'text-blue-500 bg-blue-500/10 dark:bg-blue-500/20',
                                    'time' => $sale->created_at ? $sale->created_at->diffForHumans() : 'Just now'
                                ];
                            }
                        }
                    }

                    // 5. New Purchase Alerts (created in last 2 days)
                    if (\Illuminate\Support\Facades\Schema::hasTable('purchases')) {
                        $newPurchases = \App\Models\Purchase::where('created_at', '>=', now()->subDays(2))
                            ->latest()
                            ->get();
                        foreach ($newPurchases as $purchase) {
                            $id = 'new_purchase_' . $purchase->id;
                            if (!in_array($id, $dismissed)) {
                                $supplierName = $purchase->supplier ? $purchase->supplier->name : 'Supplier';
                                $notifications[] = [
                                    'id' => $id,
                                    'type' => 'new_purchase',
                                    'title' => 'New Purchase Ordered',
                                    'message' => 'Purchase ' . $purchase->reference . ' from ' . $supplierName . ' was recorded.',
                                    'url' => route('purchase.index'),
                                    'icon' => 'fas fa-truck',
                                    'color' => 'text-purple-500 bg-purple-500/10 dark:bg-purple-500/20',
                                    'time' => $purchase->created_at ? $purchase->created_at->diffForHumans() : 'Just now'
                                ];
                            }
                        }
                    }

                    // 6. New Supplier Alerts (created in last 2 days)
                    if (\Illuminate\Support\Facades\Schema::hasTable('suppliers')) {
                        $newSuppliers = \App\Models\Supplier::where('created_at', '>=', now()->subDays(2))
                            ->latest()
                            ->get();
                        foreach ($newSuppliers as $supplier) {
                            $id = 'new_supplier_' . $supplier->id;
                            if (!in_array($id, $dismissed)) {
                                $notifications[] = [
                                    'id' => $id,
                                    'type' => 'new_supplier',
                                    'title' => 'New Supplier Registered',
                                    'message' => 'Supplier "' . $supplier->name . '" has been successfully registered.',
                                    'url' => route('supplier.index'),
                                    'icon' => 'fas fa-user-tie',
                                    'color' => 'text-indigo-500 bg-indigo-500/10 dark:bg-indigo-500/20',
                                    'time' => $supplier->created_at ? $supplier->created_at->diffForHumans() : 'Just now'
                                ];
                            }
                        }
                    }

                    $view->with('notifications', $notifications);
                } else {
                    $view->with('notifications', []);
                }
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Failed to boot notifications view composer: ' . $e->getMessage());
        }
    }
}

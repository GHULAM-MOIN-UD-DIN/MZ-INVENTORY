<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Categories\CategoriesController;
use App\Http\Controllers\Categories\Categories_List_Controller;
use App\Http\Controllers\Product\ProductController;
use App\Http\Controllers\Product\ProductListController;
use App\Http\Controllers\POSController;
use App\Http\Controllers\Sale\SaleController;
use App\Http\Controllers\Purchase\PurchaseController;
use App\Http\Controllers\Returns\ReturnController;
use App\Http\Controllers\People\CustomerController;
use App\Http\Controllers\People\SupplierController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\Auth\AuthController;

// Guest Authentication Routes
Route::middleware(['guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

// Authenticated Application Routes
Route::middleware(['auth'])->group(function () {
    
    // Logout Action
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Categories
    Route::prefix('categories')->group(function() {
        Route::get('/', [Categories_List_Controller::class, 'index'])->name('category.index');
        Route::get('/add', [CategoriesController::class, 'create'])->name('category.create');
        Route::post('/store', [CategoriesController::class, 'store'])->name('category.store');
        Route::get('/edit/{id}', [CategoriesController::class, 'edit'])->name('category.edit');
        Route::post('/update/{id}', [CategoriesController::class, 'update'])->name('category.update');
        Route::delete('/delete/{id}', [CategoriesController::class, 'destroy'])->name('category.destroy');
    });

    // Products
    Route::prefix('products')->group(function () {
        Route::get('/', [ProductListController::class, 'index'])->name('product.index');
        Route::get('/add', [ProductController::class, 'create'])->name('product.create');
        Route::get('/export', [ProductController::class, 'export'])->name('product.export');
        Route::post('/store', [ProductController::class, 'store'])->name('product.store');
        Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');
        Route::post('/update/{id}', [ProductController::class, 'update'])->name('product.update');
        Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('product.destroy');
    });

    // POS
    Route::prefix('pos')->group(function() {
        Route::get('/', [POSController::class, 'index'])->name('pos.index');
        Route::post('/checkout', [POSController::class, 'checkout'])->name('pos.checkout');
    });

    // Sales
    Route::prefix('sales')->group(function() {
        Route::get('/', [SaleController::class, 'index'])->name('sale.index');
        Route::get('/add', [SaleController::class, 'create'])->name('sale.create');
        Route::post('/store', [SaleController::class, 'store'])->name('sale.store');
        Route::get('/invoice/{id}', [SaleController::class, 'showInvoice'])->name('sale.invoice');
        Route::get('/download/{id}', [SaleController::class, 'downloadInvoice'])->name('sale.download');
        Route::post('/refund/{id}', [SaleController::class, 'refund'])->name('sale.refund');
        Route::delete('/delete/{id}', [SaleController::class, 'destroy'])->name('sale.destroy');
    });

    // Purchases
    Route::prefix('purchases')->group(function() {
        Route::get('/', [PurchaseController::class, 'index'])->name('purchase.index');
        Route::get('/add', [PurchaseController::class, 'create'])->name('purchase.create');
        Route::post('/store', [PurchaseController::class, 'store'])->name('purchase.store');
        Route::delete('/delete/{id}', [PurchaseController::class, 'destroy'])->name('purchase.destroy');
    });

    // Returns
    Route::prefix('returns')->group(function() {
        Route::get('/', [ReturnController::class, 'index'])->name('return.index');
        Route::get('/add', [ReturnController::class, 'create'])->name('return.create');
        Route::post('/store', [ReturnController::class, 'store'])->name('return.store');
        Route::delete('/delete/{id}', [ReturnController::class, 'destroy'])->name('return.destroy');
    });

    // People - Customers & Suppliers
    Route::prefix('people')->group(function() {
        Route::get('/customers', [CustomerController::class, 'index'])->name('customer.index');
        Route::get('/customers/add', [CustomerController::class, 'create'])->name('customer.create');
        Route::post('/customers/store', [CustomerController::class, 'store'])->name('customer.store');
        Route::get('/customers/edit/{id}', [CustomerController::class, 'edit'])->name('customer.edit');
        Route::post('/customers/update/{id}', [CustomerController::class, 'update'])->name('customer.update');
        Route::delete('/customers/delete/{id}', [CustomerController::class, 'destroy'])->name('customer.destroy');

        Route::get('/suppliers', [SupplierController::class, 'index'])->name('supplier.index');
        Route::get('/suppliers/add', [SupplierController::class, 'create'])->name('supplier.create');
        Route::post('/suppliers/store', [SupplierController::class, 'store'])->name('supplier.store');
        Route::get('/suppliers/edit/{id}', [SupplierController::class, 'edit'])->name('supplier.edit');
        Route::post('/suppliers/update/{id}', [SupplierController::class, 'update'])->name('supplier.update');
        Route::delete('/suppliers/delete/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');

        Route::get('/users', function() { return view('Pages.People.List_Users'); })->name('user.index');
    });

    // Reports
    Route::prefix('reports')->group(function() {
        Route::get('/', [ReportController::class, 'index'])->name('report.index');
        Route::get('/profit-loss', [ReportController::class, 'profitLoss'])->name('report.profit_loss');
        Route::get('/inventory', [ReportController::class, 'inventoryReport'])->name('report.inventory');
    });

    // Settings
    Route::prefix('settings')->group(function() {
        Route::get('/', [SettingController::class, 'index'])->name('setting.index');
        Route::post('/update', [SettingController::class, 'update'])->name('setting.update');
    });
});

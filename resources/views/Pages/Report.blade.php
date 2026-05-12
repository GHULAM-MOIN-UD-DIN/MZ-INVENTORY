@extends('Layout.index')

@section('title', 'System Reports')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Business <span class="text-orange-500">Analytics</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Deep insights into your inventory, sales, and financial performance.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                <i class="fas fa-calendar text-orange-500"></i>
                <span>{{ date('M Y') }}</span>
            </button>
        </div>
    </div>

    <!-- Report Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 stagger-2">
        <!-- Sales Report -->
        <div class="premium-card group cursor-pointer hover:border-orange-500/50 transition-all duration-300">
            <div class="p-8">
                <div class="w-16 h-16 rounded-2xl bg-orange-500/10 text-orange-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-chart-bar text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Sales Analytics</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6 text-sm">Detailed analysis of sales transactions, profit margins, and best-selling products.</p>
                <button class="w-full py-3 text-sm font-bold rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-orange-500 group-hover:text-white transition-all">Generate Report</button>
            </div>
        </div>

        <!-- Inventory Report -->
        <div class="premium-card group cursor-pointer hover:border-orange-500/50 transition-all duration-300">
            <div class="p-8">
                <div class="w-16 h-16 rounded-2xl bg-orange-500/10 text-orange-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-boxes text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Inventory Stock</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6 text-sm">Current stock levels, low stock alerts, and inventory value across warehouses.</p>
                <a href="{{ route('report.inventory') }}" class="w-full block text-center py-3 text-sm font-bold rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-orange-500 group-hover:text-white transition-all">Generate Report</a>
            </div>
        </div>

        <!-- Profit & Loss -->
        <div class="premium-card group cursor-pointer hover:border-orange-500/50 transition-all duration-300">
            <div class="p-8">
                <div class="w-16 h-16 rounded-2xl bg-orange-500/10 text-orange-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-file-invoice-dollar text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Profit & Loss</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6 text-sm">Summary of revenue, expenses, and net profit over a specific time period.</p>
                <a href="{{ route('report.profit_loss') }}" class="w-full block text-center py-3 text-sm font-bold rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-orange-500 group-hover:text-white transition-all">Generate Report</a>
            </div>
        </div>

        <!-- Purchase Report -->
        <div class="premium-card group cursor-pointer hover:border-orange-500/50 transition-all duration-300">
            <div class="p-8">
                <div class="w-16 h-16 rounded-2xl bg-orange-500/10 text-orange-500 flex items-center justify-center mb-6 group-hover:scale-110 transition-transform">
                    <i class="fas fa-shopping-cart text-2xl"></i>
                </div>
                <h3 class="text-xl font-bold mb-2">Purchase Analysis</h3>
                <p class="text-slate-500 dark:text-slate-400 mb-6 text-sm">Monitor purchase history, supplier performance, and procurement costs.</p>
                <button class="w-full py-3 text-sm font-bold rounded-xl bg-slate-100 dark:bg-slate-800 group-hover:bg-orange-500 group-hover:text-white transition-all">Generate Report</button>
            </div>
        </div>
    </div>
</div>
@endsection

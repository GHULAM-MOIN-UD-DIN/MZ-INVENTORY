@extends('Layout.index')

@section('title', 'Inventory Valuation Report')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-orange-500">
                Inventory <span class="text-slate-800 dark:text-slate-200">Valuation</span>
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Real-time audit of your stock levels and asset worth.</p>
        </div>
        <button onclick="window.print()" class="px-6 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
            <i class="fas fa-print text-orange-500"></i>
            <span>Export Report</span>
        </button>
    </div>

    <!-- Summary Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="premium-card p-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Asset Value</p>
            <h3 class="text-2xl font-black text-orange-500 mt-1">₹{{ number_format($total_value, 2) }}</h3>
        </div>
        <div class="premium-card p-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Low Stock SKUs</p>
            <h3 class="text-2xl font-black text-red-500 mt-1">{{ $low_stock_count }}</h3>
        </div>
        <div class="premium-card p-6">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Total Products</p>
            <h3 class="text-2xl font-black mt-1">{{ $products->count() }}</h3>
        </div>
    </div>

    <!-- Inventory Table -->
    <div class="premium-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="px-8 py-4 text-xs font-black uppercase text-slate-400">Product Details</th>
                        <th class="px-8 py-4 text-xs font-black uppercase text-slate-400">Category</th>
                        <th class="px-8 py-4 text-xs font-black uppercase text-slate-400 text-center">Unit Price</th>
                        <th class="px-8 py-4 text-xs font-black uppercase text-slate-400 text-center">In Stock</th>
                        <th class="px-8 py-4 text-xs font-black uppercase text-slate-400 text-right">Total Value</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @foreach($products as $p)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-4">
                                <p class="text-sm font-bold">{{ $p->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">{{ $p->code }}</p>
                            </td>
                            <td class="px-8 py-4">
                                <span class="px-3 py-1 rounded-lg bg-orange-500/10 text-orange-600 text-[10px] font-black uppercase">
                                    {{ $p->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-center text-sm font-bold">₹{{ number_format($p->price, 2) }}</td>
                            <td class="px-8 py-4 text-center">
                                <span class="px-2 py-1 rounded-md {{ $p->quantity <= 10 ? 'bg-red-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-600' }} text-[10px] font-black">
                                    {{ $p->quantity }}
                                </span>
                            </td>
                            <td class="px-8 py-4 text-right text-sm font-black">₹{{ number_format($p->quantity * $p->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

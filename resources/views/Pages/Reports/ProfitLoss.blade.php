@extends('Layout.index')

@section('title', 'Profit & Loss Statement')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-orange-500">
                Profit & Loss <span class="text-slate-800 dark:text-slate-200">Statement</span>
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Detailed breakdown of your business financial health.</p>
        </div>
        <button onclick="window.print()" class="px-6 py-2.5 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
            <i class="fas fa-print text-orange-500"></i>
            <span>Print Statement</span>
        </button>
    </div>

    <!-- Summary Grid -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="premium-card p-8 bg-gradient-to-br from-white to-orange-50/30 dark:from-slate-900 dark:to-orange-950/10">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Revenue</p>
            <h3 class="text-3xl font-black text-slate-800 dark:text-slate-100">Rs. {{ number_format($sales, 2) }}</h3>
            <div class="mt-4 flex items-center gap-2 text-orange-500 text-[10px] font-black uppercase">
                <i class="fas fa-arrow-up"></i>
                <span>From Sales History</span>
            </div>
        </div>

        <div class="premium-card p-8 bg-gradient-to-br from-white to-orange-50/30 dark:from-slate-900 dark:to-orange-950/10">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total COGS & Expenses</p>
            <h3 class="text-3xl font-black text-slate-800 dark:text-slate-100">Rs. {{ number_format($purchases + $expenses, 2) }}</h3>
            <div class="mt-4 flex items-center gap-2 text-orange-500 text-[10px] font-black uppercase">
                <i class="fas fa-arrow-down"></i>
                <span>Purchases + Op. Costs</span>
            </div>
        </div>

        <div class="premium-card p-8 bg-orange-500 text-white shadow-orange-500/20">
            <p class="text-[10px] font-black uppercase tracking-widest text-white/70 mb-2">Net Profit</p>
            <h3 class="text-3xl font-black">Rs. {{ number_format($net_profit, 2) }}</h3>
            <div class="mt-4 flex items-center gap-2 text-white/80 text-[10px] font-black uppercase">
                <i class="fas fa-chart-line"></i>
                <span>Final Earnings</span>
            </div>
        </div>
    </div>

    <!-- Detailed Table -->
    <div class="premium-card overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
            <h4 class="font-extrabold text-xs uppercase tracking-widest text-slate-500">Statement Breakdown</h4>
        </div>
        <div class="p-8 space-y-4">
            <div class="flex justify-between items-center py-4 border-b border-slate-100 dark:border-slate-800">
                <span class="text-sm font-bold">Total Sales Revenue (+)</span>
                <span class="text-sm font-black text-orange-500">Rs. {{ number_format($sales, 2) }}</span>
            </div>
            <div class="flex justify-between items-center py-4 border-b border-slate-100 dark:border-slate-800">
                <span class="text-sm font-bold">Cost of Goods Sold (Purchases) (-)</span>
                <span class="text-sm font-black text-slate-400">Rs. {{ number_format($purchases, 2) }}</span>
            </div>
            <div class="flex justify-between items-center py-4 border-b-2 border-slate-200 dark:border-slate-700 bg-slate-50/30 dark:bg-slate-800/30 px-4 -mx-4 rounded-lg">
                <span class="text-sm font-black uppercase tracking-tight text-orange-500">Gross Profit</span>
                <span class="text-sm font-black text-orange-500">Rs. {{ number_format($gross_profit, 2) }}</span>
            </div>
            <div class="flex justify-between items-center py-4 border-b border-slate-100 dark:border-slate-800">
                <span class="text-sm font-bold">Operational Expenses (-)</span>
                <span class="text-sm font-black text-slate-400">Rs. {{ number_format($expenses, 2) }}</span>
            </div>
            <div class="flex justify-between items-center py-6">
                <span class="text-lg font-black uppercase tracking-widest text-orange-600">Net Profit</span>
                <span class="text-2xl font-black text-orange-600">Rs. {{ number_format($net_profit, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Recent Expenses -->
    <div class="premium-card overflow-hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
            <h4 class="font-extrabold text-xs uppercase tracking-widest text-slate-500">Operational Expenses List</h4>
            <a href="{{ route('report.index') }}" class="text-[10px] font-black text-orange-500 uppercase">Manage Expenses</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="px-8 py-3 text-[10px] font-black uppercase text-slate-400">Date</th>
                        <th class="px-8 py-3 text-[10px] font-black uppercase text-slate-400">Category</th>
                        <th class="px-8 py-3 text-[10px] font-black uppercase text-slate-400">Reference</th>
                        <th class="px-8 py-3 text-[10px] font-black uppercase text-slate-400 text-right">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($recent_expenses as $exp)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-8 py-4 text-xs font-bold text-slate-600">{{ $exp->date }}</td>
                            <td class="px-8 py-4 text-xs font-black text-orange-500 uppercase tracking-tighter">{{ $exp->category }}</td>
                            <td class="px-8 py-4 text-xs font-bold">{{ $exp->reference }}</td>
                            <td class="px-8 py-4 text-xs font-black text-right text-orange-600">Rs. {{ number_format($exp->amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="px-8 py-10 text-center text-slate-400 text-[10px] font-black uppercase tracking-widest">No expenses recorded</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

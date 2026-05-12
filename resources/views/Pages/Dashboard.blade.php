@extends('Layout.index')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Quick Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Total Sales -->
        <div class="premium-card p-6 stagger-1 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                    <i class="fas fa-sack-dollar text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Total Revenue</p>
                    <h3 class="text-2xl font-black">Rs. {{ number_format($total_sales, 0) }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="text-[10px] font-bold px-2 py-1 bg-orange-500/10 text-orange-600 rounded-lg">+12.5%</span>
                <span class="text-[10px] text-slate-400 font-medium italic">vs last month</span>
            </div>
        </div>

        <!-- Total Purchases -->
        <div class="premium-card p-6 stagger-2 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-slate-500/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 flex items-center justify-center">
                    <i class="fas fa-cart-shopping text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Total Expense</p>
                    <h3 class="text-2xl font-black">Rs. {{ number_format($total_purchases, 0) }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="text-[10px] font-bold px-2 py-1 bg-orange-500/10 text-orange-600 rounded-lg">+5.2%</span>
                <span class="text-[10px] text-slate-400 font-medium italic">inventory growth</span>
            </div>
        </div>

        <!-- Net Profit -->
        <div class="premium-card p-6 stagger-3 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-orange-500/10 text-orange-600 flex items-center justify-center">
                    <i class="fas fa-chart-pie text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Net Profit</p>
                    <h3 class="text-2xl font-black text-orange-600">Rs. {{ number_format($net_profit, 0) }}</h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <div class="w-full bg-slate-100 dark:bg-slate-800 h-1.5 rounded-full overflow-hidden">
                    <div class="bg-orange-500 h-full w-[65%]"></div>
                </div>
            </div>
        </div>

        <!-- Inventory Status -->
        <div class="premium-card p-6 stagger-4 relative overflow-hidden group">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-500/5 rounded-full group-hover:scale-150 transition-transform duration-500"></div>
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 rounded-2xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                    <i class="fas fa-box-open text-xl"></i>
                </div>
                <div>
                    <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest">Active Stock</p>
                    <h3 class="text-2xl font-black">{{ $total_products }} <span class="text-xs text-slate-400 font-bold uppercase tracking-tighter">Items</span></h3>
                </div>
            </div>
            <div class="mt-4 flex items-center gap-2">
                <span class="text-[10px] font-bold text-orange-600">{{ $low_stock_products->count() }} Items low in stock!</span>
            </div>
        </div>
    </div>

    <!-- Analytics & Alerts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Sales Trend Chart -->
        <div class="lg:col-span-2 premium-card p-8 stagger-5">
            <div class="flex items-center justify-between mb-8">
                <div>
                    <h3 class="text-lg font-bold">Revenue Analytics</h3>
                    <p class="text-xs text-slate-400">Daily sales performance for the last 7 days</p>
                </div>
                <div class="flex items-center gap-2 px-3 py-1 bg-slate-50 dark:bg-slate-900 rounded-lg border border-slate-100 dark:border-slate-800">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    <span class="text-[10px] font-bold uppercase tracking-widest">Live Feed</span>
                </div>
            </div>
            <div id="salesChart" class="min-h-[300px]"></div>
        </div>

        <!-- Low Stock Alerts -->
        <div class="premium-card p-8 stagger-6">
            <div class="flex items-center gap-3 mb-8">
                <div class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                    <i class="fas fa-triangle-exclamation"></i>
                </div>
                <h3 class="text-lg font-bold">Stock Alerts</h3>
            </div>
            <div class="space-y-4">
                @forelse($low_stock_products as $p)
                    <div class="flex items-center justify-between p-3 rounded-xl bg-orange-500/5 border border-orange-500/10 group hover:bg-orange-500/10 transition-all">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-lg bg-white dark:bg-slate-800 overflow-hidden border border-slate-100 dark:border-slate-800">
                                <img src="{{ $p->image ? asset($p->image) : 'https://ui-avatars.com/api/?name='.urlencode($p->name).'&background=f97316&color=fff' }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-xs font-bold truncate max-w-[120px]">{{ $p->name }}</p>
                                <p class="text-[9px] font-extrabold text-orange-500 uppercase">{{ $p->quantity }} left</p>
                            </div>
                        </div>
                        <a href="{{ route('product.edit', $p->id) }}" class="w-8 h-8 rounded-lg bg-white dark:bg-slate-800 shadow-sm flex items-center justify-center text-slate-400 hover:text-orange-500 transition-colors">
                            <i class="fas fa-plus text-[10px]"></i>
                        </a>
                    </div>
                @empty
                    <div class="py-10 text-center space-y-3">
                        <div class="w-12 h-12 bg-orange-500/10 text-orange-500 rounded-full flex items-center justify-center mx-auto">
                            <i class="fas fa-check"></i>
                        </div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Inventory Healthy</p>
                    </div>
                @endforelse
            </div>
            <a href="{{ route('product.index') }}" class="mt-6 block text-center py-3 rounded-xl border-2 border-slate-100 dark:border-slate-800 text-[10px] font-bold uppercase tracking-widest hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">View All Products</a>
        </div>
    </div>

    <!-- Recent Activity & Latest Products -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Sales -->
        <div class="premium-card stagger-7 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <h3 class="font-bold">Recent Transactions</h3>
                <a href="{{ route('sale.index') }}" class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Full History</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Invoice</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Customer</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Amount</th>
                            <th class="px-6 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                        @foreach($recent_sales as $sale)
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-900/50 transition-colors">
                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold text-orange-500">#{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</p>
                                    <p class="text-[9px] text-slate-400 font-medium">{{ $sale->created_at->format('M d, Y') }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs font-bold">{{ $sale->customer->name ?? 'Walk-in' }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-xs font-black">Rs. {{ number_format($sale->grand_total, 2) }}</p>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-black uppercase bg-orange-500/10 text-orange-600">
                                        {{ $sale->status }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Latest Products -->
        <div class="premium-card stagger-8 overflow-hidden">
            <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                <h3 class="font-bold">Newly Added Products</h3>
                <a href="{{ route('product.create') }}" class="text-[10px] font-bold text-orange-500 uppercase tracking-widest">Add New</a>
            </div>
            <div class="p-6 space-y-6">
                @foreach($latest_products as $p)
                    <div class="flex items-center justify-between group">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-xl bg-slate-100 dark:bg-slate-800 overflow-hidden border border-slate-100 dark:border-slate-800">
                                <img src="{{ $p->image ? asset($p->image) : 'https://ui-avatars.com/api/?name='.urlencode($p->name).'&background=f97316&color=fff' }}" class="w-full h-full object-cover">
                            </div>
                            <div>
                                <p class="text-sm font-bold">{{ $p->name }}</p>
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $p->category->name ?? 'No Category' }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-sm font-black">Rs. {{ number_format($p->price, 2) }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase">{{ $p->quantity }} in stock</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const options = {
            series: [{
                name: 'Revenue',
                data: @json($chart_values)
            }],
            chart: {
                height: 350,
                type: 'area',
                toolbar: { show: false },
                sparkline: { enabled: false },
                animations: { enabled: true, easing: 'easeinout', speed: 800 }
            },
            colors: ['#f97316'],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [20, 100]
                }
            },
            stroke: { curve: 'smooth', width: 3 },
            dataLabels: { enabled: false },
            grid: {
                borderColor: localStorage.getItem('theme') === 'dark' ? '#1e293b' : '#f1f5f9',
                strokeDashArray: 4,
                padding: { left: 0, right: 0 }
            },
            xaxis: {
                categories: @json($chart_labels),
                labels: {
                    style: { colors: '#64748b', fontSize: '10px', fontWeight: 600 }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function(val) { return 'Rs. ' + val.toLocaleString(); },
                    style: { colors: '#64748b', fontSize: '10px', fontWeight: 600 }
                }
            },
            tooltip: {
                theme: localStorage.getItem('theme') === 'dark' ? 'dark' : 'light',
                x: { format: 'dd MMM' }
            }
        };

        const chart = new ApexCharts(document.querySelector("#salesChart"), options);
        chart.render();
    });
</script>
@endsection
@extends('Layout.index')

@section('title', 'Sales Management')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Sales <span class="text-orange-500">History</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Track and manage all your outgoing sales transactions.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('pos.index') }}" class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                <i class="fas fa-cash-register text-orange-500"></i>
                <span>POS System</span>
            </a>
            <a href="{{ route('sale.create') }}" class="btn-premium">
                <i class="fas fa-plus"></i>
                <span>Create Sale</span>
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6 stagger-2 px-4 md:px-0">
        <div class="premium-card p-4 md:p-6">
            <p class="text-[8px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Revenue</p>
            <h3 class="text-base md:text-2xl font-extrabold mt-1 text-orange-500">Rs. {{ number_format($sales->where('status', '!=', 'Refunded')->sum('grand_total'), 0) }}</h3>
        </div>
        <div class="premium-card p-4 md:p-6">
            <p class="text-[8px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Orders</p>
            <h3 class="text-base md:text-2xl font-extrabold mt-1">{{ $sales->count() }}</h3>
        </div>
        <div class="premium-card p-4 md:p-6">
            <p class="text-[8px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Active</p>
            <h3 class="text-base md:text-2xl font-extrabold mt-1">{{ $sales->where('status', 'Completed')->count() }}</h3>
        </div>
        <div class="premium-card p-4 md:p-6">
            <p class="text-[8px] md:text-xs font-bold text-slate-400 uppercase tracking-widest">Avg Order</p>
            <h3 class="text-base md:text-2xl font-extrabold mt-1 text-orange-500">Rs. {{ number_format($sales->where('status', '!=', 'Refunded')->avg('grand_total') ?? 0, 0) }}</h3>
        </div>
    </div>

    <!-- Sales Table -->
    <div class="premium-card overflow-hidden stagger-3 mx-4 md:mx-0">
        <div class="max-h-[500px] overflow-y-auto overflow-x-auto custom-scrollbar scrollbar-thin scrollbar-thumb-slate-200 dark:scrollbar-thumb-slate-800">
            <table class="w-full text-left min-w-[1000px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400">Transaction</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400">Customer</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Status</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Amount</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Payment</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($sales as $sale)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-8">
                                <div>
                                    <p class="text-sm font-bold text-orange-500">{{ $sale->reference }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ date('M d, Y', strtotime($sale->date)) }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-8">
                                <div>
                                    <p class="text-sm font-bold">{{ $sale->customer->name ?? 'Walk-in Customer' }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $sale->customer->phone ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-center">
                                <span class="px-2 py-1 rounded-md bg-orange-500/10 text-orange-600 dark:text-orange-400 text-[10px] font-extrabold uppercase">
                                    {{ $sale->status }}
                                </span>
                            </td>
                            <td class="py-4 px-8 text-center text-sm font-bold">Rs. {{ number_format($sale->grand_total, 2) }}</td>
                            <td class="py-4 px-8 text-center">
                                <span class="px-2 py-1 rounded-md {{ $sale->payment_status == 'Paid' ? 'bg-orange-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }} text-[9px] font-extrabold uppercase">
                                    {{ $sale->payment_status }}
                                </span>
                            </td>
                            <td class="py-4 px-8 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('sale.invoice', $sale->id) }}" class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all shadow-sm" title="Download Invoice">
                                        <i class="fas fa-file-pdf text-[10px]"></i>
                                    </a>
                                    @if($sale->status != 'Refunded')
                                        <form id="refund-form-{{ $sale->id }}" action="{{ route('sale.refund', $sale->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="button" onclick="confirmRefund({{ $sale->id }})" class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all shadow-sm" title="Process Refund">
                                                <i class="fas fa-rotate-left text-[10px]"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <form id="delete-sale-form-{{ $sale->id }}" action="{{ route('sale.destroy', $sale->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteSale({{ $sale->id }})" class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                                <i class="fas fa-receipt text-4xl mb-4 block opacity-20"></i>
                                No sales transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmRefund(id) {
    Swal.fire({
        icon: 'warning',
        title: 'Process Refund?',
        text: 'This sale will be refunded and product quantities will be restored to inventory.',
        showCancelButton: true,
        confirmButtonText: 'Yes, Refund',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('refund-form-' + id).submit();
        }
    });
}

function confirmDeleteSale(id) {
    Swal.fire({
        icon: 'error',
        title: 'Delete Sale?',
        text: 'This sale record will be permanently removed. This action cannot be undone.',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-sale-form-' + id).submit();
        }
    });
}
</script>
@endsection

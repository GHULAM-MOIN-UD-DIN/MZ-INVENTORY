@extends('Layout.index')

@section('title', 'Purchase Management')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Purchase <span class="text-orange-500">History</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Track your stock acquisitions and supplier payments.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                <i class="fas fa-file-export text-orange-500"></i>
                <span>Export Report</span>
            </button>
            <a href="{{ route('purchase.create') }}" class="btn-premium">
                <i class="fas fa-plus"></i>
                <span>Add Purchase</span>
            </a>
        </div>
    </div>

    <!-- Stats Overview -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 stagger-2">
        <div class="premium-card p-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Total Acquisitions</p>
            <h3 class="text-2xl font-extrabold mt-1 text-orange-500">₹{{ number_format($purchases->sum('grand_total'), 2) }}</h3>
        </div>
        <div class="premium-card p-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Orders Count</p>
            <h3 class="text-2xl font-extrabold mt-1">{{ $purchases->count() }}</h3>
        </div>
        <div class="premium-card p-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Received</p>
            <h3 class="text-2xl font-extrabold mt-1">{{ $purchases->where('status', 'Received')->count() }}</h3>
        </div>
        <div class="premium-card p-6">
            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Paid Invoices</p>
            <h3 class="text-2xl font-extrabold mt-1">{{ $purchases->where('payment_status', 'Paid')->count() }}</h3>
        </div>
    </div>

    <!-- Purchase Table -->
    <div class="premium-card overflow-hidden stagger-3">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Transaction Details</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Supplier</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Status</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Total Amount</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Payment</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($purchases as $purchase)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-8">
                                <div>
                                    <p class="text-sm font-bold text-orange-500">{{ $purchase->reference }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ date('M d, Y', strtotime($purchase->date)) }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-8">
                                <div>
                                    <p class="text-sm font-bold">{{ $purchase->supplier->name ?? 'Internal Supplier' }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">{{ $purchase->supplier->phone ?? 'N/A' }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-center">
                                <span class="px-2 py-1 rounded-md bg-orange-500/10 text-orange-600 dark:text-orange-400 text-[10px] font-extrabold uppercase">
                                    {{ $purchase->status }}
                                </span>
                            </td>
                            <td class="py-4 px-8 text-center text-sm font-bold">₹{{ number_format($purchase->grand_total, 2) }}</td>
                            <td class="py-4 px-8 text-center">
                                <span class="px-2 py-1 rounded-md {{ $purchase->payment_status == 'Paid' ? 'bg-orange-500 text-white' : 'bg-slate-100 dark:bg-slate-800 text-slate-400' }} text-[9px] font-extrabold uppercase">
                                    {{ $purchase->payment_status }}
                                </span>
                            </td>
                            <td class="py-4 px-8 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                        <i class="fas fa-eye text-xs"></i>
                                    </button>
                                    <form id="delete-purchase-form-{{ $purchase->id }}" action="{{ route('purchase.destroy', $purchase->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeletePurchase({{ $purchase->id }})" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                                <i class="fas fa-cart-shopping text-4xl mb-4 block opacity-20"></i>
                                No purchase transactions found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDeletePurchase(id) {
    Swal.fire({
        icon: 'error',
        title: 'Delete Purchase?',
        text: 'This purchase record will be permanently removed. This cannot be undone.',
        showCancelButton: true,
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('delete-purchase-form-' + id).submit();
        }
    });
}
</script>
@endsection

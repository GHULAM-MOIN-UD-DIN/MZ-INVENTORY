@extends('Layout.index')

@section('title', 'Returns Management')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Returns <span class="text-orange-500">Log</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage sales returns and stock adjustments efficiently.</p>
        </div>
        <a href="{{ route('return.create') }}" class="btn-premium">
            <i class="fas fa-plus"></i>
            <span>Create Return</span>
        </a>
    </div>

    <!-- Returns Table -->
    <div class="premium-card overflow-hidden stagger-2">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Date & Ref</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Entity</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Type</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Total Amount</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($returns as $return)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-8">
                                <div>
                                    <p class="text-sm font-bold text-orange-500">{{ $return->reference }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase">{{ date('M d, Y', strtotime($return->date)) }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-8">
                                <div>
                                    <p class="text-sm font-bold">{{ $return->customer->name ?? $return->supplier->name ?? 'Walk-in' }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">
                                        {{ isset($return->customer) ? 'Customer' : (isset($return->supplier) ? 'Supplier' : 'N/A') }}
                                    </p>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-center">
                                <span class="px-2 py-1 rounded-md bg-orange-500/10 text-orange-600 dark:text-orange-400 text-[10px] font-extrabold uppercase">
                                    {{ $return->type }}
                                </span>
                            </td>
                            <td class="py-4 px-8 text-center text-sm font-bold">₹{{ number_format($return->grand_total, 2) }}</td>
                            <td class="py-4 px-8 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <button class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                        <i class="fas fa-eye text-xs"></i>
                                    </button>
                                    <form action="{{ route('return.destroy', $return->id) }}" method="POST" class="inline" onsubmit="return confirm('Remove this return record?')">
                                        @csrf @method('DELETE')
                                        <button class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                                <i class="fas fa-undo text-4xl mb-4 block opacity-20"></i>
                                No return records found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

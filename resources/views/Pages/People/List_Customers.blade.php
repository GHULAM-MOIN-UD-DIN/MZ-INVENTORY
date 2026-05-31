@extends('Layout.index')

@section('title', 'Customer Directory')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Customer <span class="text-orange-500">Directory</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage your customer base and track their ordering patterns.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                <i class="fas fa-file-import text-orange-500"></i>
                <span>Import</span>
            </button>
            <a href="{{ route('customer.create') }}" class="btn-premium">
                <i class="fas fa-user-plus"></i>
                <span>Add Customer</span>
            </a>
        </div>
    </div>

    <!-- Customer Table -->
    <div class="premium-card overflow-hidden stagger-2">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Customer Info</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Contact Details</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Location</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Engagement</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($customers as $customer)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center text-white font-bold shadow-md shadow-orange-500/20">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{ $customer->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Active Client</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-8">
                                <div>
                                    <p class="text-sm font-bold text-slate-600 dark:text-slate-300">{{ $customer->phone }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold tracking-tight">{{ $customer->email }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-sm font-bold text-slate-400">{{ $customer->city ?? 'Not Specified' }}</td>
                            <td class="py-4 px-8 text-center">
                                <span class="px-2 py-1 rounded-md bg-orange-500/10 text-orange-600 dark:text-orange-400 text-[10px] font-extrabold uppercase">
                                    {{ $customer->sales->count() ?? 0 }} Orders
                                </span>
                            </td>
                            <td class="py-4 px-8 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('customer.edit', $customer->id) }}" class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                        <i class="fas fa-user-edit text-xs"></i>
                                    </a>
                                    <form id="delete-cust-form-{{ $customer->id }}" action="{{ route('customer.destroy', $customer->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteCust({{ $customer->id }})" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                                <i class="fas fa-users-slash text-4xl mb-4 block opacity-20"></i>
                                No customers in directory.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function confirmDeleteCust(id) {
    Swal.fire({ icon:'error', title:'Delete Customer?', text:'This customer record will be permanently removed.', showCancelButton:true, confirmButtonText:'Delete', cancelButtonText:'Cancel' }).then((r) => { if(r.isConfirmed) document.getElementById('delete-cust-form-'+id).submit(); });
}
</script>
@endsection

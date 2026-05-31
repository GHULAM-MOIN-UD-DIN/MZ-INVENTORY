@extends('Layout.index')

@section('title', 'Supplier Network')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Supplier <span class="text-orange-500">Network</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage your product vendors and supply chain partners.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                <i class="fas fa-truck text-orange-500"></i>
                <span>Manage Fleet</span>
            </button>
            <a href="{{ route('supplier.create') }}" class="btn-premium">
                <i class="fas fa-plus"></i>
                <span>Add Supplier</span>
            </a>
        </div>
    </div>

    <!-- Supplier Table -->
    <div class="premium-card overflow-hidden stagger-2">
        <div class="max-h-[500px] overflow-y-auto overflow-x-auto custom-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Supplier Name</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Contact Person</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Contact Info</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Location</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($suppliers as $supplier)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center text-white font-bold shadow-md shadow-orange-500/20">
                                        {{ strtoupper(substr($supplier->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{ $supplier->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-tight">Active Vendor</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-sm font-bold text-slate-600 dark:text-slate-300">{{ $supplier->contact_person }}</td>
                            <td class="py-4 px-8">
                                <div>
                                    <p class="text-sm font-bold text-slate-600 dark:text-slate-300">{{ $supplier->phone }}</p>
                                    <p class="text-[10px] text-slate-400 font-bold tracking-tight">{{ $supplier->email }}</p>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-sm font-bold text-slate-400 italic">{{ $supplier->city ?? 'Global' }}</td>
                            <td class="py-4 px-8 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('supplier.edit', $supplier->id) }}" class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                        <i class="fas fa-edit text-xs"></i>
                                    </a>
                                    <form id="delete-sup-form-{{ $supplier->id }}" action="{{ route('supplier.destroy', $supplier->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteSup({{ $supplier->id }})" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                                <i class="fas fa-truck text-4xl mb-4 block opacity-20"></i>
                                No suppliers registered.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
function confirmDeleteSup(id) {
    Swal.fire({ icon:'error', title:'Delete Supplier?', text:'This supplier will be permanently removed.', showCancelButton:true, confirmButtonText:'Delete', cancelButtonText:'Cancel' }).then((r) => { if(r.isConfirmed) document.getElementById('delete-sup-form-'+id).submit(); });
}
</script>
@endsection

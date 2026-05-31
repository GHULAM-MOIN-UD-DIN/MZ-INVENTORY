@extends('Layout.index')

@section('title', 'Product Types')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Product <span class="text-orange-500">Types</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage custom product types for your inventory items.</p>
        </div>
        <a href="{{ route('product-type.create') }}" class="btn-premium">
            <i class="fas fa-plus"></i>
            <span>Add Product Type</span>
        </a>
    </div>

    <!-- Table Section -->
    <div class="premium-card overflow-hidden stagger-2">
        <div class="max-h-[500px] overflow-y-auto overflow-x-auto custom-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Type Name</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($productTypes as $type)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-orange-500/10 flex items-center justify-center text-orange-500">
                                        <i class="fas fa-box-open text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{ $type->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('product-type.edit', $type->id) }}" class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form id="delete-type-form-{{ $type->id }}" action="{{ route('product-type.destroy', $type->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteType({{ $type->id }})" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                                No product types defined.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($productTypes->hasPages())
            <div class="p-6 border-t border-slate-100 dark:border-slate-800">
                {{ $productTypes->links() }}
            </div>
        @endif
    </div>
</div>
<script>
function confirmDeleteType(id) {
    Swal.fire({ icon:'error', title:'Delete Product Type?', text:'This product type will be permanently removed.', showCancelButton:true, confirmButtonText:'Delete', cancelButtonText:'Cancel' }).then((r) => { if(r.isConfirmed) document.getElementById('delete-type-form-'+id).submit(); });
}
</script>
@endsection

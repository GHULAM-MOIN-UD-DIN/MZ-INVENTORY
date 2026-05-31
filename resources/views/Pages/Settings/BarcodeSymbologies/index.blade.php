@extends('Layout.index')

@section('title', 'Barcode Symbologies')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Barcode <span class="text-orange-500">Symbologies</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage barcode types for your products.</p>
        </div>
        <a href="{{ route('barcode-symbology.create') }}" class="btn-premium">
            <i class="fas fa-plus"></i>
            <span>Add Barcode Symbology</span>
        </a>
    </div>

    <!-- Table Section -->
    <div class="premium-card overflow-hidden stagger-2">
        <div class="max-h-[500px] overflow-y-auto overflow-x-auto custom-scrollbar">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Symbology Name</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Format Base</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($barcodeSymbologies as $symbology)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-orange-500/10 flex items-center justify-center text-orange-500">
                                        <i class="fas fa-barcode text-sm"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{ $symbology->name }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-center">
                                <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-xs font-extrabold text-orange-500">
                                    {{ $symbology->format_type ?? 'CODE128' }}
                                </span>
                            </td>
                            <td class="py-4 px-8 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('barcode-symbology.edit', $symbology->id) }}" class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form id="delete-symbology-form-{{ $symbology->id }}" action="{{ route('barcode-symbology.destroy', $symbology->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteSymbology({{ $symbology->id }})" class="w-8 h-8 rounded-lg bg-red-500/10 text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                                No barcode symbologies defined.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($barcodeSymbologies->hasPages())
            <div class="p-6 border-t border-slate-100 dark:border-slate-800">
                {{ $barcodeSymbologies->links() }}
            </div>
        @endif
    </div>
</div>

<script>
    function confirmDeleteSymbology(id) {
        Swal.fire({
            icon: 'warning',
            title: 'Delete Barcode Symbology?',
            text: 'This barcode symbology will be permanently removed. This cannot be undone.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-symbology-form-' + id).submit();
            }
        });
    }
</script>
@endsection

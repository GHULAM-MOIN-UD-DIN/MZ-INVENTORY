@extends('Layout.index')

@section('title', 'Product Categories')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Product <span class="text-orange-500">Categories</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Organize your inventory with custom product categories.</p>
        </div>
        <a href="{{ route('category.create') }}" class="btn-premium">
            <i class="fas fa-plus"></i>
            <span>Add Category</span>
        </a>
    </div>

    <!-- Table Section -->
    <div class="premium-card overflow-hidden stagger-2">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50">
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400">Category Info</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-center">Total Products</th>
                        <th class="py-4 px-8 text-xs font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($categories as $category)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-8">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl overflow-hidden bg-orange-500/10 flex items-center justify-center text-orange-500">
                                        @if($category->image)
                                            <img src="{{ cloudinary_url($category->image) }}" class="w-full h-full object-cover" alt="{{ $category->name }}">
                                        @else
                                            <i class="fas fa-tags text-sm"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold">{{ $category->name }}</p>
                                        <p class="text-[10px] text-slate-400 uppercase font-bold tracking-tight">System Category</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-8 text-center">
                                <span class="px-3 py-1 rounded-full bg-slate-100 dark:bg-slate-800 text-xs font-extrabold text-orange-500">
                                    {{ $category->products_count ?? 0 }} Items
                                </span>
                            </td>
                            <td class="py-4 px-8 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('category.edit', $category->id) }}" class="w-8 h-8 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this category?')">
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
                            <td colspan="3" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                                No categories defined.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

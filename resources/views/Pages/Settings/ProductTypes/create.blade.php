@extends('Layout.index')

@section('title', 'Add Product Type')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-orange-500">
                Add Product Type
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Create a new product type for your inventory.</p>
        </div>
        <a href="{{ route('product-type.index') }}" 
           class="group flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-orange-500 transition-all">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="premium-card overflow-hidden">
        <div class="h-2 bg-gradient-to-r from-orange-400 to-orange-600"></div>
        
        <form action="{{ route('product-type.store') }}" method="POST" class="p-8 space-y-8">
            @csrf

            <div class="form-group group">
                <label class="form-label flex items-center gap-1">
                    Product Type Name 
                    <span class="text-orange-500">*</span>
                </label>
                <div class="relative">
                    <input type="text" name="name" 
                           class="form-input" 
                           placeholder="e.g. Standard, Digital, Combo" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 border-t-2 border-slate-100 dark:border-slate-800">
                <button type="submit" 
                        class="w-full sm:w-auto px-10 py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 
                               hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl shadow-lg shadow-orange-500/25 transition-all">
                    <i class="fas fa-save mr-2"></i>Save Type
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

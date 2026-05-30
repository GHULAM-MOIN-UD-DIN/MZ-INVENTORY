@extends('Layout.index')

@section('title', 'Update Product')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-orange-500">
                Update <span class="text-slate-800 dark:text-slate-200">Product</span>
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Modify product details and stock information.</p>
        </div>
        <a href="{{ route('product.index') }}" 
           class="group flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 dark:text-slate-400 hover:text-orange-500 transition-all">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="premium-card overflow-hidden">
        <div class="h-2 bg-gradient-to-r from-orange-400 to-orange-600"></div>
        
        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data" 
              class="p-8 space-y-8" id="productForm">
            @csrf
            @method('POST')

            <!-- Basic Info -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-edit text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Product Information</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Essential details of your product</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-group group">
                        <label class="form-label">Product Name *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-tag text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                            </div>
                            <input type="text" name="name" class="form-input pl-12" value="{{ $product->name }}" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label">Product Code *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-barcode text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                            </div>
                            <input type="text" name="code" class="form-input pl-12" value="{{ $product->code }}" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label">Category *</label>
                        <select name="category_id" class="form-input appearance-none" required>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group group">
                        <label class="form-label">Barcode Symbology *</label>
                        <select name="barcode_symbology" class="form-input appearance-none" required>
                            <option value="CODE128" {{ $product->barcode_symbology == 'CODE128' ? 'selected' : '' }}>CODE128</option>
                            <option value="CODE39" {{ $product->barcode_symbology == 'CODE39' ? 'selected' : '' }}>CODE39</option>
                            <option value="EAN8" {{ $product->barcode_symbology == 'EAN8' ? 'selected' : '' }}>EAN8</option>
                            <option value="EAN13" {{ $product->barcode_symbology == 'EAN13' ? 'selected' : '' }}>EAN13</option>
                            <option value="UPCA" {{ $product->barcode_symbology == 'UPCA' ? 'selected' : '' }}>UPC-A</option>
                            <option value="UPCE" {{ $product->barcode_symbology == 'UPCE' ? 'selected' : '' }}>UPC-E</option>
                        </select>
                    </div>

                    <div class="form-group group">
                        <label class="form-label">Tax Method *</label>
                        <select name="tax_method" class="form-input appearance-none" required>
                            <option value="Exclusive" {{ $product->tax_method == 'Exclusive' ? 'selected' : '' }}>Exclusive</option>
                            <option value="Inclusive" {{ $product->tax_method == 'Inclusive' ? 'selected' : '' }}>Inclusive</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-4">
                    <input type="hidden" name="type" value="Standard">
                    
                    <div class="form-group group">
                        <label class="form-label">Cost Price *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-[10px] text-slate-400 group-focus-within:text-orange-500 font-black transition-colors">Rs.</span>
                            </div>
                            <input type="number" step="0.01" name="cost" class="form-input pl-10" value="{{ $product->cost }}" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label">Selling Price *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-[10px] text-slate-400 group-focus-within:text-orange-500 font-black transition-colors">Rs.</span>
                            </div>
                            <input type="number" step="0.01" name="price" class="form-input pl-10" value="{{ $product->price }}" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label">Quantity *</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-boxes-stacked text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                            </div>
                            <input type="number" name="quantity" class="form-input pl-12" value="{{ $product->quantity }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media -->
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-image text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Product Media</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Update product visuals</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-start gap-8">
                    @if($product->image)
                        <div class="w-48 h-48 rounded-2xl overflow-hidden border-2 border-orange-500/20 shadow-xl shrink-0 group relative">
                            <img src="{{ $product->image ? cloudinary_url($product->image) : asset('assets/images/no-image.png') }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="text-white text-[10px] font-bold uppercase tracking-widest">Current Image</span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="relative group cursor-pointer flex-1 w-full">
                        <input type="file" name="image" class="absolute inset-0 opacity-0 cursor-pointer z-10" accept="image/*">
                        <div class="p-10 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl flex flex-col items-center justify-center gap-3 group-hover:border-orange-500 group-hover:bg-orange-500/5 transition-all">
                            <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900/20 flex items-center justify-center text-orange-500">
                                <i class="fas fa-cloud-arrow-up text-xl"></i>
                            </div>
                            <p class="text-sm font-bold text-slate-600 dark:text-slate-300">Choose new image to replace</p>
                            <p class="text-xs text-slate-400">PNG, JPG or WEBP (Max. 5MB)</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-8 border-t-2 border-slate-100 dark:border-slate-800 flex justify-end gap-4">
                <a href="{{ route('product.index') }}" class="px-8 py-3.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Cancel Changes
                </a>
                <button type="submit" class="px-10 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i>
                    Update Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

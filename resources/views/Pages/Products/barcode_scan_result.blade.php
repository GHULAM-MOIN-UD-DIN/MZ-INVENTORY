@extends('Layout.index')

@section('title', 'Barcode Scan Result')

@section('content')
<div class="max-w-3xl mx-auto space-y-6 animate-fade-in">

    @if($product)
        {{-- Product Found --}}
        <div class="premium-card overflow-hidden">
            {{-- Header with gradient --}}
            <div class="bg-gradient-to-r from-orange-500 to-orange-400 p-4 sm:p-6 text-white flex items-center gap-3 sm:gap-4">
                <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center flex-shrink-0">
                    <i class="fas fa-barcode text-xl sm:text-2xl"></i>
                </div>
                <div class="min-w-0">
                    <h2 class="text-xl sm:text-2xl font-extrabold tracking-tight truncate">Product Found</h2>
                    <p class="text-white/80 text-xs sm:text-sm font-medium mt-0.5">Scanned Code: <span class="font-bold text-white">{{ $product->code }}</span></p>
                </div>
            </div>

            <div class="p-6 md:p-8">
                {{-- Product Image + Main Info --}}
                <div class="flex flex-col md:flex-row gap-6 mb-8">
                    {{-- Image --}}
                    <div class="w-full md:w-48 h-48 rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-800 flex-shrink-0">
                        @if($product->image)
                            <img src="{{ cloudinary_url($product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-orange-50 to-orange-100 dark:from-slate-800 dark:to-slate-900">
                                <i class="fas fa-box text-5xl text-orange-300 dark:text-orange-500/30 mb-2"></i>
                                <span class="text-orange-400 text-xs font-bold uppercase tracking-widest">No Image</span>
                            </div>
                        @endif
                    </div>

                    {{-- Main Info --}}
                    <div class="flex-1 space-y-3">
                        <h3 class="text-2xl font-extrabold leading-tight">{{ $product->name }}</h3>
                        <div class="flex flex-wrap gap-2">
                            <span class="px-3 py-1 rounded-lg bg-orange-500/10 text-orange-600 dark:text-orange-400 text-xs font-extrabold uppercase tracking-wider">
                                {{ $product->category->name ?? 'N/A' }}
                            </span>
                            <span class="px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 text-xs font-extrabold uppercase tracking-wider">
                                {{ $product->type }}
                            </span>
                            <span class="px-3 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 text-xs font-extrabold uppercase tracking-wider">
                                {{ $product->barcode_symbology }}
                            </span>
                        </div>
                        @if($product->description)
                            <p class="text-slate-500 dark:text-slate-400 text-sm leading-relaxed">{{ $product->description }}</p>
                        @endif
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    {{-- Selling Price --}}
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100/50 dark:from-orange-950/30 dark:to-orange-900/10 rounded-2xl p-5 text-center border border-orange-100 dark:border-orange-900/30">
                        <div class="w-10 h-10 bg-orange-500 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-orange-500/20">
                            <i class="fas fa-tag text-white text-sm"></i>
                        </div>
                        <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">Selling Price</p>
                        <p class="text-xl font-black text-orange-600 dark:text-orange-400">Rs. {{ number_format($product->price, 2) }}</p>
                    </div>

                    {{-- Cost Price --}}
                    <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-5 text-center border border-slate-100 dark:border-slate-800">
                        <div class="w-10 h-10 bg-slate-500 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-slate-500/10">
                            <i class="fas fa-coins text-white text-sm"></i>
                        </div>
                        <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">Cost Price</p>
                        <p class="text-xl font-black">Rs. {{ number_format($product->cost, 2) }}</p>
                    </div>

                    {{-- Stock --}}
                    <div class="rounded-2xl p-5 text-center border {{ $product->quantity > 0 ? 'bg-emerald-50 dark:bg-emerald-950/20 border-emerald-100 dark:border-emerald-900/30' : 'bg-red-50 dark:bg-red-950/20 border-red-100 dark:border-red-900/30' }}">
                        <div class="w-10 h-10 {{ $product->quantity > 0 ? 'bg-emerald-500' : 'bg-red-500' }} rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg {{ $product->quantity > 0 ? 'shadow-emerald-500/20' : 'shadow-red-500/20' }}">
                            <i class="fas fa-cubes text-white text-sm"></i>
                        </div>
                        <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">In Stock</p>
                        <p class="text-xl font-black {{ $product->quantity > 0 ? 'text-emerald-600 dark:text-emerald-400' : 'text-red-600 dark:text-red-400' }}">
                            {{ $product->quantity }} <span class="text-xs font-bold">Units</span>
                        </p>
                    </div>

                    {{-- Profit Margin --}}
                    <div class="bg-purple-50 dark:bg-purple-950/20 rounded-2xl p-5 text-center border border-purple-100 dark:border-purple-900/30">
                        <div class="w-10 h-10 bg-purple-500 rounded-xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-purple-500/20">
                            <i class="fas fa-chart-line text-white text-sm"></i>
                        </div>
                        <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-1">Profit</p>
                        <p class="text-xl font-black text-purple-600 dark:text-purple-400">Rs. {{ number_format($product->price - $product->cost, 2) }}</p>
                    </div>
                </div>

                {{-- Details Table --}}
                <div class="bg-slate-50 dark:bg-slate-800/30 rounded-2xl p-5 border border-slate-100 dark:border-slate-800">
                    <h4 class="text-xs font-extrabold uppercase tracking-widest text-slate-400 mb-4">
                        <i class="fas fa-info-circle text-orange-500 mr-2"></i>Full Details
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-y-3 gap-x-8 text-sm">
                        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
                            <span class="text-slate-400 font-bold">Product Code</span>
                            <span class="font-extrabold text-orange-500">{{ $product->code }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
                            <span class="text-slate-400 font-bold">Category</span>
                            <span class="font-extrabold">{{ $product->category->name ?? 'N/A' }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
                            <span class="text-slate-400 font-bold">Product Type</span>
                            <span class="font-extrabold">{{ $product->type }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
                            <span class="text-slate-400 font-bold">Barcode Format</span>
                            <span class="font-extrabold">{{ $product->barcode_symbology }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
                            <span class="text-slate-400 font-bold">Tax Method</span>
                            <span class="font-extrabold">{{ $product->tax_method }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b border-dashed border-slate-200 dark:border-slate-700">
                            <span class="text-slate-400 font-bold">Added On</span>
                            <span class="font-extrabold">{{ $product->created_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Barcode Display --}}
                <div class="mt-6 text-center">
                    <div class="inline-block bg-white p-4 sm:p-6 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-w-full overflow-x-auto">
                        <svg id="productBarcode" class="max-w-full h-auto"></svg>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex flex-wrap gap-3 mt-6 justify-center">
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                    <a href="{{ route('product.edit', $product->id) }}" class="px-6 py-3 rounded-xl bg-orange-500 text-white font-bold text-xs uppercase tracking-widest hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 flex items-center gap-2">
                        <i class="fas fa-pen"></i> Edit Product
                    </a>
                    @endif
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                    <a href="{{ route('product.index') }}" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 font-bold text-xs uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                    @else
                    <a href="{{ route('pos.index') }}" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 font-bold text-xs uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to POS
                    </a>
                    @endif
                    <button onclick="window.print()" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 font-bold text-xs uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                        <i class="fas fa-print"></i> Print
                    </button>
                </div>
            </div>
        </div>

    @else
        {{-- Product Not Found --}}
        <div class="premium-card overflow-hidden">
            <div class="bg-gradient-to-r from-red-500 to-red-400 p-6 text-white flex items-center gap-4">
                <div class="w-14 h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-2xl"></i>
                </div>
                <div>
                    <h2 class="text-2xl font-extrabold tracking-tight">Product Not Found</h2>
                    <p class="text-white/80 text-sm font-medium mt-0.5">Scanned Code: <span class="font-bold text-white">{{ $code }}</span></p>
                </div>
            </div>
            <div class="p-12 text-center">
                <i class="fas fa-box-open text-6xl text-slate-200 dark:text-slate-700 mb-6 block"></i>
                <p class="text-slate-400 text-sm mb-6">No product was found matching this barcode in your inventory.</p>
                <div class="flex justify-center gap-3">
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                    <a href="{{ route('product.create') }}" class="px-6 py-3 rounded-xl bg-orange-500 text-white font-bold text-xs uppercase tracking-widest hover:bg-orange-600 transition-all shadow-lg shadow-orange-500/20 flex items-center gap-2">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                    @endif
                    @if(auth()->user()->role === 'admin' || auth()->user()->role === 'manager')
                    <a href="{{ route('product.index') }}" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 font-bold text-xs uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to Products
                    </a>
                    @else
                    <a href="{{ route('pos.index') }}" class="px-6 py-3 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 font-bold text-xs uppercase tracking-widest hover:bg-slate-200 dark:hover:bg-slate-700 transition-all flex items-center gap-2">
                        <i class="fas fa-arrow-left"></i> Back to POS
                    </a>
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>

@if($product)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let format = '{{ $product->barcode_symbology }}' || 'CODE128';
        if (format === 'C128') format = 'CODE128';
        if (format === 'C39') format = 'CODE39';

        try {
            JsBarcode("#productBarcode", "{{ $product->code }}", {
                format: format,
                width: 2,
                height: 70,
                displayValue: true,
                fontSize: 14,
                font: "Outfit",
                margin: 10
            });
        } catch(e) {
            try {
                JsBarcode("#productBarcode", "{{ $product->code }}", {
                    format: "CODE128",
                    width: 2,
                    height: 70,
                    displayValue: true,
                    fontSize: 14,
                    font: "Outfit",
                    margin: 10
                });
            } catch(e2) {
                console.error("Barcode generation error: ", e2);
            }
        }
    });
</script>
@endif
@endsection

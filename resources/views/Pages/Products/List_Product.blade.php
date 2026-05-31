@extends('Layout.index')

@section('title', 'Product Inventory')

@section('content')
<div class="space-y-8 animate-fade-in">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 stagger-1">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Product <span class="text-orange-500">Inventory</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Manage and track your full product collection in real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('product.export') }}" class="px-4 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-bold flex items-center gap-2 hover:bg-slate-50 dark:hover:bg-slate-800 transition-all shadow-sm">
                <i class="fas fa-file-export text-orange-500"></i>
                <span>Export CSV</span>
            </a>
            <a href="{{ route('product.create') }}" class="btn-premium">
                <i class="fas fa-plus"></i>
                <span>Add Product</span>
            </a>
        </div>
    </div>

    <!-- Filters & Search -->
    <form method="GET" action="{{ route('product.index') }}" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 stagger-2">
        <div class="sm:col-span-2 lg:col-span-3 flex gap-2">
            <div class="relative flex-1 group">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, code or scan barcode..." class="form-input pl-12 w-full" autofocus>
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
            </div>
            <button type="button" onclick="scanProductListCamera()" class="px-4 py-3 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition-all flex items-center justify-center gap-2 shadow-lg shadow-orange-500/20" title="Scan Barcode using Camera">
                <i class="fas fa-camera text-sm"></i>
                <span class="hidden sm:inline text-xs font-black uppercase tracking-wider">Scan Camera</span>
            </button>
            <button type="submit" class="hidden">Search</button>
        </div>
        <div class="relative">
            <select name="category" class="form-input appearance-none cursor-pointer w-full pr-10" onchange="this.form.submit()">
                <option value="">All Categories</option>
                @foreach($categories ?? [] as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
            <i class="fas fa-chevron-down absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none text-xs"></i>
        </div>
    </form>

    <!-- Products Table -->
    <div class="premium-card overflow-hidden stagger-3">
        <div class="max-h-[500px] overflow-y-auto overflow-x-auto scrollbar-thin scrollbar-thumb-slate-200 dark:scrollbar-thumb-slate-800 custom-scrollbar">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-900/50 border-b border-slate-100 dark:border-slate-800">
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400">Product Info</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400">Category</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Cost</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Price</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Stock</th>
                        <th class="py-4 px-6 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    @forelse($products as $product)
                        <tr class="group hover:bg-orange-500/5 transition-colors">
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-slate-100 dark:bg-slate-800 overflow-hidden border border-slate-200 dark:border-slate-700 flex-shrink-0">
                                        @if($product->image)
                                            <img src="{{ $product->image ? cloudinary_url($product->image) : 'https://ui-avatars.com/api/?name='.urlencode($product->name).'&background=f97316&color=fff' }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center bg-orange-500/10 text-orange-500 text-xs font-bold">
                                                {{ substr($product->name, 0, 2) }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="min-w-0">
                                        <p class="text-sm font-bold truncate max-w-[150px]">{{ $product->name }}</p>
                                        <p class="text-[9px] text-slate-400 uppercase font-bold tracking-tight">{{ $product->code }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="py-4 px-6">
                                <span class="px-2 py-1 rounded-md bg-orange-500/10 text-orange-600 dark:text-orange-400 text-[9px] font-extrabold uppercase">
                                    {{ $product->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="py-4 px-6 text-sm font-bold text-center text-slate-400">Rs. {{ number_format($product->cost, 2) }}</td>
                            <td class="py-4 px-6 text-sm font-bold text-center">Rs. {{ number_format($product->price, 2) }}</td>
                            <td class="py-4 px-6 text-center">
                                <div class="flex flex-col items-center">
                                    <span class="font-extrabold text-base text-orange-500">
                                        {{ $product->quantity }}
                                    </span>
                                    <span class="text-[8px] font-bold text-slate-400 uppercase">Units</span>
                                </div>
                            </td>
                            <td class="py-4 px-6 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <button onclick="printBarcode(this)" 
                                            data-code="{{ $product->code }}"
                                            data-name="{{ $product->name }}"
                                            data-price="{{ number_format($product->price, 2) }}"
                                            data-symbology="{{ $product->barcode_symbology }}"
                                            class="w-7 h-7 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all"
                                            title="Print Barcode">
                                        <i class="fas fa-barcode text-[10px]"></i>
                                    </button>
                                    <a href="{{ route('product.edit', $product->id) }}" class="w-7 h-7 rounded-lg bg-orange-500/10 text-orange-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                        <i class="fas fa-pen text-[10px]"></i>
                                    </a>
                                    <form id="delete-product-form-{{ $product->id }}" action="{{ route('product.destroy', $product->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDeleteProduct({{ $product->id }})" class="w-7 h-7 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                                            <i class="fas fa-trash text-[10px]"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                                <i class="fas fa-box-open text-4xl mb-4 block opacity-20"></i>
                                No products found in inventory
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($products->hasPages())
            <div class="p-6 border-t border-slate-100 dark:border-slate-800">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

<!-- Barcode Modal -->
<div id="barcodeModal" class="fixed inset-0 z-[100] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm p-4">
    <div class="bg-white dark:bg-slate-900 rounded-2xl w-full max-w-md overflow-hidden shadow-2xl animate-slide-up">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
            <h3 class="font-extrabold text-orange-500 uppercase tracking-widest text-xs">Product Label</h3>
            <button onclick="closeBarcodeModal()" class="text-slate-400 hover:text-slate-600 transition-colors"><i class="fas fa-times"></i></button>
        </div>
        <div class="p-8 text-center" id="printableBarcode">
            <h4 id="barcodeProductName" class="text-sm font-bold mb-2"></h4>
            
            <!-- Tab Switcher -->
            <div class="flex justify-center gap-2 mb-4">
                <button onclick="switchBarcodeTab('barcode')" id="tabBarcode" class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-orange-500 text-white transition-all">Barcode</button>
                <button onclick="switchBarcodeTab('qrcode')" id="tabQrcode" class="px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-500 transition-all">QR Code</button>
            </div>
            
            <!-- Barcode -->
            <div id="barcodeView" class="bg-white p-4 rounded-xl inline-flex justify-center border border-slate-100 mb-2 max-w-full overflow-x-auto">
                <svg id="barcodeSVG" class="max-w-full h-auto"></svg>
            </div>
            
            <!-- QR Code (encodes URL for scanning) -->
            <div id="qrcodeView" class="hidden">
                <div class="bg-white p-4 rounded-xl inline-block border border-slate-100 mb-2">
                    <div id="qrCanvas" class="flex justify-center bg-white"></div>
                </div>
                <p class="text-[9px] text-slate-400 font-bold mt-1"><i class="fas fa-mobile-alt text-orange-500 mr-1"></i>Scan with phone camera to see product details</p>
            </div>
            
            <p id="barcodePrice" class="text-lg font-black text-orange-500 mt-2"></p>
        </div>
        <div class="p-6 bg-slate-50 dark:bg-slate-800/50 flex gap-3">
            <button onclick="closeBarcodeModal()" class="flex-1 py-3 rounded-xl text-xs font-bold uppercase tracking-widest text-slate-500 hover:bg-slate-200 transition-all">Cancel</button>
            <a id="viewDetailsBtn" href="#" class="flex-1 py-3 rounded-xl bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-widest text-center hover:bg-slate-300 transition-all flex items-center justify-center gap-1.5">
                <i class="fas fa-eye text-[10px]"></i> Details
            </a>
            <button onclick="doPrint()" class="flex-1 py-3 rounded-xl bg-orange-500 text-white text-xs font-bold uppercase tracking-widest shadow-lg shadow-orange-500/20 hover:bg-orange-600 transition-all">Print Label</button>
        </div>
    </div>
</div>

<script>
    function switchBarcodeTab(tab) {
        const barcodeView = document.getElementById('barcodeView');
        const qrcodeView = document.getElementById('qrcodeView');
        const tabBarcode = document.getElementById('tabBarcode');
        const tabQrcode = document.getElementById('tabQrcode');
        
        if (tab === 'barcode') {
            barcodeView.classList.remove('hidden');
            qrcodeView.classList.add('hidden');
            tabBarcode.className = 'px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-orange-500 text-white transition-all';
            tabQrcode.className = 'px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-500 transition-all';
        } else {
            barcodeView.classList.add('hidden');
            qrcodeView.classList.remove('hidden');
            tabQrcode.className = 'px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-orange-500 text-white transition-all';
            tabBarcode.className = 'px-4 py-1.5 rounded-lg text-[10px] font-black uppercase tracking-widest bg-slate-100 dark:bg-slate-800 text-slate-500 transition-all';
        }
    }

    function printBarcode(btn) {
        const code = btn.getAttribute('data-code');
        const name = btn.getAttribute('data-name');
        const price = btn.getAttribute('data-price');
        const symbology = btn.getAttribute('data-symbology');
        const scanUrl = window.location.origin + '/p/' + encodeURIComponent(code);

        document.getElementById('barcodeProductName').textContent = name;
        document.getElementById('barcodePrice').textContent = 'Rs. ' + price;
        document.getElementById('viewDetailsBtn').href = scanUrl;
        
        // Reset to barcode tab
        switchBarcodeTab('barcode');
        
        // Generate Barcode
        let format = symbology || 'CODE128';
        if (format === 'C128') format = 'CODE128';
        if (format === 'C39') format = 'CODE39';
        
        try {
            JsBarcode("#barcodeSVG", code, {
                format: format,
                width: 2,
                height: 60,
                displayValue: true,
                fontSize: 12,
                font: "Outfit"
            });
        } catch(e) {
            try {
                JsBarcode("#barcodeSVG", code, {
                    format: "CODE128",
                    width: 2,
                    height: 60,
                    displayValue: true,
                    fontSize: 12,
                    font: "Outfit"
                });
            } catch(e2) {
                console.error("Barcode generation error: ", e2);
            }
        }
        
        // Generate QR Code with scan URL
        try {
            const qrContainer = document.getElementById('qrCanvas');
            if (qrContainer && typeof QRCode !== 'undefined') {
                qrContainer.innerHTML = '';
                new QRCode(qrContainer, {
                    text: scanUrl,
                    width: 160,
                    height: 160,
                    colorDark : "#0f172a",
                    colorLight : "#ffffff",
                    correctLevel : QRCode.CorrectLevel.M
                });
            } else {
                console.warn('QRCode library is not loaded or Container is missing.');
            }
        } catch (e) {
            console.error('QR Code generation failed:', e);
        }
        
        document.getElementById('barcodeModal').classList.remove('hidden');
    }

    function closeBarcodeModal() {
        document.getElementById('barcodeModal').classList.add('hidden');
    }

    function doPrint() {
        const content = document.getElementById('printableBarcode').innerHTML;
        const win = window.open('', '_blank');
        win.document.write(`
            <html>
                <head>
                    <title>Print Barcode</title>
                    <style>
                        body { font-family: 'Outfit', sans-serif; text-align: center; padding: 20px; }
                        h4 { margin: 0 0 10px 0; font-size: 14px; }
                        p { margin: 10px 0 0 0; font-size: 18px; font-weight: bold; color: #f97316; }
                        svg, canvas, img { max-width: 100%; }
                        button { display: none !important; }
                        .hidden { display: none !important; }
                    </style>
                </head>
                <body onload="window.print();window.close()">
                    ${content}
                </body>
            </html>
        `);
        win.document.close();
    }

    function scanProductListCamera() {
        startGlobalCameraScanner(function(code) {
            let cleanCode = code;
            if (code.includes('/barcode/scan/')) {
                const parts = code.split('/barcode/scan/');
                cleanCode = parts[parts.length - 1];
            }
            window.location.href = window.location.origin + '/barcode/scan/' + encodeURIComponent(cleanCode);
        });
    }

    function confirmDeleteProduct(id) {
        Swal.fire({
            icon: 'error',
            title: 'Delete Product?',
            text: 'This product will be permanently removed from inventory. This cannot be undone.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-product-form-' + id).submit();
            }
        });
    }
</script>
@endsection


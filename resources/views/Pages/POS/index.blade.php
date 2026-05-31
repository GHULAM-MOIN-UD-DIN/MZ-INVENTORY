@extends('Layout.index')

@section('title', 'Point of Sale')

@section('content')
<!-- Floating Cart Button for Mobile -->
<button onclick="scrollToCart()" 
        class="lg:hidden fixed bottom-6 right-6 z-[100] w-14 h-14 bg-orange-500 text-white rounded-full shadow-2xl flex items-center justify-center animate-bounce">
    <i class="fas fa-shopping-cart"></i>
    <span id="mobileCartCount" class="absolute -top-1 -right-1 bg-white text-orange-500 text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-orange-500">0</span>
</button>

<div class="min-h-[calc(100vh-120px)] lg:h-[calc(100vh-120px)] flex flex-col lg:flex-row gap-6 animate-fade-in lg:overflow-hidden pb-20 lg:pb-0">
    <!-- Left Side: Product Selection -->
    <div class="flex-1 flex flex-col gap-6 lg:overflow-hidden">
        <!-- Search & Filter -->
        <div class="premium-card p-4 flex flex-col sm:flex-row gap-4 stagger-1">
            <div class="relative flex-1 flex gap-2">
                <div class="relative flex-1">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                    <input type="text" id="productSearch" placeholder="Scan Barcode or Search..." 
                           class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 focus:border-orange-500 transition-all text-sm">
                </div>
                <button type="button" onclick="scanPOSCamera()" class="px-4 py-3 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition-all flex items-center justify-center gap-2 shadow-lg shadow-orange-500/20" title="Scan Barcode using Camera">
                    <i class="fas fa-camera text-sm"></i>
                    <span class="hidden sm:inline text-xs font-black uppercase tracking-wider">Scan Camera</span>
                </button>
            </div>
            <select id="categoryFilter" class="px-6 py-3 rounded-xl border-2 border-slate-100 dark:border-slate-800 bg-slate-50 dark:bg-slate-900 font-bold text-[10px] uppercase tracking-widest text-slate-500">
                <option value="">All Categories</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Products Grid -->
        <div class="flex-1 lg:overflow-y-auto pr-2 custom-scrollbar stagger-2">
            <div class="grid grid-cols-2 sm:grid-cols-3 xl:grid-cols-4 gap-3 md:gap-4" id="productsGrid">
                @forelse($products as $p)
                    <div onclick="addToCart({{ json_encode($p) }})" 
                         data-code="{{ strtolower($p->code) }}"
                         class="premium-card group cursor-pointer hover:border-orange-500 transition-all active:scale-95 overflow-hidden">
                        <div class="h-28 sm:h-32 bg-slate-50 dark:bg-slate-800 relative">
                            <img src="{{ $p->image ? cloudinary_url($p->image) : 'https://ui-avatars.com/api/?name='.urlencode($p->name).'&background=f97316&color=fff' }}" 
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform">
                            <div class="absolute top-2 right-2 px-1.5 py-0.5 bg-orange-500 text-white text-[8px] font-black rounded-md">
                                Qty: {{ $p->quantity }}
                            </div>
                        </div>
                        <div class="p-3">
                            <h4 class="text-[11px] font-bold truncate leading-tight">{{ $p->name }}</h4>
                            <p class="text-orange-600 font-black text-xs mt-1">Rs. {{ number_format($p->price, 0) }}</p>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center text-slate-400 font-bold uppercase tracking-widest text-xs">
                        No products found.
                    </div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $products->links() }}
            </div>
        </div>
    </div>

    <!-- Right Side: Cart & Checkout -->
    <div id="cartSection" class="w-full lg:w-[400px] flex flex-col gap-6 stagger-3 scroll-mt-20">
        <div class="premium-card flex-1 flex flex-col lg:overflow-hidden border-2 border-orange-500/20">
            <!-- Customer Selection -->
            <div class="p-4 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div class="flex-1">
                    <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-1">Customer</label>
                    <select id="posCustomer" class="w-full py-1 bg-transparent font-bold text-xs border-none focus:ring-0">
                        <option value="">Walk-in Customer</option>
                        @foreach($customers as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center hover:text-orange-500 transition-colors">
                    <i class="fas fa-user-plus text-xs"></i>
                </button>
            </div>

            <!-- Cart Items -->
            <div class="min-h-[200px] lg:flex-1 lg:overflow-y-auto p-4 space-y-3 custom-scrollbar" id="cartItems">
                <div class="h-full flex flex-col items-center justify-center text-slate-400 opacity-30 py-10">
                    <i class="fas fa-shopping-cart text-4xl mb-3"></i>
                    <p class="text-[10px] font-black uppercase tracking-widest">Cart is Empty</p>
                </div>
            </div>

            <!-- Calculation & Checkout -->
            <div class="p-5 bg-slate-50 dark:bg-slate-900 border-t border-slate-100 dark:border-slate-800 space-y-3">
                <div class="flex justify-between items-center text-[11px] font-bold">
                    <span class="text-slate-500 uppercase tracking-widest">Subtotal</span>
                    <span id="subtotalAmount">Rs. 0.00</span>
                </div>
                <div class="flex justify-between items-center gap-4">
                    <span class="text-[11px] font-bold text-slate-500 uppercase tracking-widest">Discount</span>
                    <input type="number" id="posDiscount" value="0" oninput="calculateTotals()" 
                           class="w-20 text-right bg-transparent border-b border-slate-200 dark:border-slate-700 font-black text-orange-500 focus:outline-none text-sm">
                </div>
                
                <div class="grid grid-cols-2 gap-3 pt-2">
                    <div class="col-span-2 sm:col-span-1">
                        <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-1">Method</label>
                        <select id="posPaymentMethod" class="w-full py-2 bg-white dark:bg-slate-800 rounded-lg border-none focus:ring-orange-500 font-bold text-[10px]">
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Credit">Credit</option>
                        </select>
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label class="text-[8px] font-black text-slate-400 uppercase tracking-widest block mb-1">Cash Received</label>
                        <input type="number" id="cashReceived" placeholder="0" oninput="calculateTotals()"
                               class="w-full py-2 px-3 bg-white dark:bg-slate-800 rounded-lg border border-slate-200 dark:border-slate-700 focus:ring-2 focus:ring-orange-500 font-black text-sm text-green-600">
                    </div>
                </div>

                <div class="flex justify-between items-center text-[10px] font-bold pt-1">
                    <span class="text-slate-500 uppercase tracking-widest">Change Return</span>
                    <span id="changeAmount" class="font-black text-slate-700 dark:text-slate-200">Rs. 0.00</span>
                </div>

                <div class="pt-3 border-t border-slate-200 dark:border-slate-700 flex justify-between items-center">
                    <span class="text-xs font-black uppercase tracking-widest">Total</span>
                    <span id="grandTotalAmount" class="text-xl font-black text-orange-600">Rs. 0.00</span>
                </div>

                <div class="grid grid-cols-2 gap-2 pt-3">
                    <button onclick="clearCart()" class="py-3 rounded-xl bg-slate-200 dark:bg-slate-800 text-slate-500 text-[9px] font-black uppercase tracking-widest hover:bg-red-500 hover:text-white transition-all">Clear</button>
                    <button onclick="completeSale()" class="py-3 rounded-xl bg-orange-500 text-white text-[9px] font-black uppercase tracking-widest shadow-lg shadow-orange-500/20 hover:bg-orange-600 transition-all">Checkout</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Success -->
<div id="successModal" class="fixed inset-0 z-[200] hidden flex items-center justify-center bg-black/60 backdrop-blur-md">
    <div class="bg-white dark:bg-slate-900 rounded-3xl p-8 w-full max-w-sm text-center animate-slide-up">
        <div class="w-20 h-20 bg-orange-500 text-white rounded-full flex items-center justify-center mx-auto mb-6 text-3xl shadow-lg shadow-orange-500/30">
            <i class="fas fa-check"></i>
        </div>
        <h3 class="text-2xl font-black mb-2">Sale Completed!</h3>
        <p class="text-slate-500 text-sm mb-8">Transaction recorded successfully.</p>
        <div class="flex flex-col gap-3">
            <button onclick="printLastInvoice()" class="py-4 rounded-2xl bg-orange-500 text-white font-black text-xs uppercase tracking-widest hover:bg-orange-600 transition-all">Print Receipt</button>
            <button onclick="location.reload()" class="py-4 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-500 font-black text-xs uppercase tracking-widest hover:bg-slate-200 transition-all">Start New Sale</button>
        </div>
    </div>
</div>

<script>
    let cart = [];
    let lastInvoiceUrl = null;

    function scrollToCart() {
        document.getElementById('cartSection').scrollIntoView({ behavior: 'smooth' });
    }

    function addToCart(product) {
        const existing = cart.find(item => item.id === product.id);
        if (existing) {
            if (existing.qty < product.quantity) {
                existing.qty++;
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Out of Stock',
                    text: 'Cannot add more items than available stock.',
                    confirmButtonColor: '#f97316'
                });
            }
        } else {
            cart.push({ ...product, qty: 1 });
        }
        renderCart();
    }

    function renderCart() {
        const container = document.getElementById('cartItems');
        if (cart.length === 0) {
            container.innerHTML = `
                <div class="h-full flex flex-col items-center justify-center text-slate-400 opacity-30">
                    <i class="fas fa-shopping-cart text-5xl mb-4"></i>
                    <p class="text-xs font-black uppercase tracking-widest">Cart is Empty</p>
                </div>`;
            const mobileBadge = document.getElementById('mobileCartCount');
            if (mobileBadge) mobileBadge.textContent = 0;
            calculateTotals();
            return;
        }

        // Update Mobile Cart Badge
        const totalItems = cart.reduce((acc, item) => acc + item.qty, 0);
        const mobileBadge = document.getElementById('mobileCartCount');
        if (mobileBadge) mobileBadge.textContent = totalItems;

        container.innerHTML = cart.map((item, index) => `
            <div class="flex items-center justify-between group bg-slate-50 dark:bg-slate-800/50 p-3 rounded-xl">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-orange-500 text-white flex items-center justify-center font-black text-[10px]">
                        ${item.qty}
                    </div>
                    <div>
                        <p class="text-xs font-bold truncate max-w-[150px]">${item.name}</p>
                        <p class="text-[10px] text-orange-500 font-black">Rs. ${parseFloat(item.price * item.qty).toLocaleString()}</p>
                    </div>
                </div>
                <div class="flex items-center gap-1">
                    <button onclick="updateQty(${index}, -1)" class="w-6 h-6 rounded-md bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-xs hover:bg-orange-500 hover:text-white">-</button>
                    <button onclick="updateQty(${index}, 1)" class="w-6 h-6 rounded-md bg-slate-200 dark:bg-slate-800 flex items-center justify-center text-xs hover:bg-orange-500 hover:text-white">+</button>
                    <button onclick="removeFromCart(${index})" class="w-6 h-6 rounded-md bg-red-500 text-white flex items-center justify-center text-xs ml-2"><i class="fas fa-trash text-[8px]"></i></button>
                </div>
            </div>
        `).join('');
        calculateTotals();
    }

    function updateQty(index, delta) {
        cart[index].qty += delta;
        if (cart[index].qty <= 0) cart.splice(index, 1);
        else if (cart[index].qty > cart[index].quantity) {
            cart[index].qty = cart[index].quantity;
            Swal.fire({
                icon: 'warning',
                title: 'Max Stock Reached',
                text: 'Cannot exceed available stock limit.',
                confirmButtonColor: '#f97316'
            });
        }
        renderCart();
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        renderCart();
    }

    function clearCart() {
        Swal.fire({
            title: 'Clear Cart?',
            text: 'Are you sure you want to clear the entire cart?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, clear it',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#f97316',
            cancelButtonColor: '#64748b'
        }).then((result) => {
            if (result.isConfirmed) {
                cart = [];
                renderCart();
            }
        });
    }

    function calculateTotals() {
        const subtotal = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
        const discount = parseFloat(document.getElementById('posDiscount').value) || 0;
        const total = Math.max(0, subtotal - discount);

        const cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;
        const change = Math.max(0, cashReceived - total);

        document.getElementById('subtotalAmount').textContent = 'Rs. ' + subtotal.toLocaleString();
        document.getElementById('grandTotalAmount').textContent = 'Rs. ' + total.toLocaleString();
        document.getElementById('changeAmount').textContent = 'Rs. ' + change.toLocaleString();
    }

    function completeSale() {
        if (cart.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Empty Cart',
                text: 'Please add items to cart first!',
                confirmButtonColor: '#f97316'
            });
            return;
        }
        
        const subtotal = cart.reduce((acc, item) => acc + (item.price * item.qty), 0);
        const discount = parseFloat(document.getElementById('posDiscount').value) || 0;
        const total = Math.max(0, subtotal - discount);
        const cashReceived = parseFloat(document.getElementById('cashReceived').value) || 0;

        if (document.getElementById('posPaymentMethod').value === 'Cash' && cashReceived < total) {
            Swal.fire({
                icon: 'warning',
                title: 'Insufficient Cash',
                text: 'Cash received is less than total payable amount!',
                confirmButtonColor: '#f97316'
            });
            return;
        }

        const customerVal = document.getElementById('posCustomer').value;
        const data = {
            customer_id: customerVal || null,
            payment_method: document.getElementById('posPaymentMethod').value,
            items: cart.map(item => ({ id: item.id, qty: item.qty, price: item.price })),
            discount: discount,
            grand_total: total,
            cash_received: cashReceived,
            change_return: Math.max(0, cashReceived - total),
            _token: '{{ csrf_token() }}'
        };

        const btn = event.target;
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Processing...';

        fetch('{{ route('pos.checkout') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
            body: JSON.stringify(data)
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                lastInvoiceUrl = data.invoice_url;
                Swal.fire({
                    title: 'Sale Completed!',
                    text: 'Transaction recorded successfully.',
                    icon: 'success',
                    showCancelButton: true,
                    confirmButtonText: 'Print Receipt',
                    cancelButtonText: 'New Sale',
                    confirmButtonColor: '#f97316',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.open(data.invoice_url, '_blank');
                    }
                    location.reload();
                });
            } else {
                Swal.fire('Error', data.message, 'error');
                btn.disabled = false;
                btn.innerHTML = 'Checkout Now';
            }
        })
        .catch(err => {
            Swal.fire('Error', 'Something went wrong!', 'error');
            btn.disabled = false;
            btn.innerHTML = 'Checkout Now';
        });
    }

    function printLastInvoice() {
        if (lastInvoiceUrl) {
            window.open(lastInvoiceUrl, '_blank');
        }
    }

    // Real-time Search & Barcode Scanner Support
    let scanBuffer = '';
    let scanTimeout = null;
    const searchInput = document.getElementById('productSearch');

    // Detect barcode scanner input (rapid keypresses)
    searchInput.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const searchVal = searchInput.value.trim();
            if (searchVal.length > 0) {
                // Try barcode lookup via API
                fetch('{{ route("barcode.lookup") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ code: searchVal })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.found) {
                        // Auto-add to cart
                        const p = data.product;
                        addToCart({
                            id: p.id,
                            name: p.name,
                            code: p.code,
                            price: parseFloat(p.price),
                            quantity: p.quantity,
                            image: p.image
                        });
                        searchInput.value = '';
                        // Reset filter display
                        const cards = document.querySelectorAll('#productsGrid > div[data-code]');
                        cards.forEach(card => card.style.display = 'block');
                        
                        // Success beep feedback
                        Swal.fire({
                            toast: true,
                            position: 'top-end',
                            icon: 'success',
                            title: p.name + ' added to cart!',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                        });
                    } else {
                        // Not found - do normal search filter
                        filterProducts(searchVal);
                    }
                })
                .catch(err => {
                    filterProducts(searchVal);
                });
            }
            return;
        }
    });

    searchInput.addEventListener('input', function(e) {
        const search = e.target.value.toLowerCase();
        filterProducts(search);
    });

    function filterProducts(search) {
        search = search.toLowerCase();
        const cards = document.querySelectorAll('#productsGrid > div[data-code]');
        cards.forEach(card => {
            const name = card.querySelector('h4').textContent.toLowerCase();
            const code = card.getAttribute('data-code');
            if (name.includes(search) || code.includes(search)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Category Filter
    document.getElementById('categoryFilter').addEventListener('change', function(e) {
        const catId = e.target.value;
        window.location.href = `{{ route('pos.index') }}?category_id=${catId}`;
    });

    function scanPOSCamera() {
        startGlobalCameraScanner(function(code) {
            let cleanCode = code;
            if (code.includes('/barcode/scan/')) {
                const parts = code.split('/barcode/scan/');
                cleanCode = parts[parts.length - 1];
            }
            
            fetch('{{ route("barcode.lookup") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ code: cleanCode })
            })
            .then(res => res.json())
            .then(data => {
                if (data.found) {
                    const p = data.product;
                    addToCart({
                        id: p.id,
                        name: p.name,
                        code: p.code,
                        price: parseFloat(p.price),
                        quantity: p.quantity,
                        image: p.image
                    });
                    
                    Swal.fire({
                        toast: true,
                        position: 'top-end',
                        icon: 'success',
                        title: p.name + ' added to cart!',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true
                    });
                } else {
                    Swal.fire('Product Not Found', 'No product found with code: ' + cleanCode, 'error');
                }
            })
            .catch(err => {
                console.error("Error lookup scanned code:", err);
                Swal.fire('Error', 'Failed to lookup scanned code', 'error');
            });
        });
    }
</script>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 4px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #f9731633; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #f97316; }
</style>
@endsection

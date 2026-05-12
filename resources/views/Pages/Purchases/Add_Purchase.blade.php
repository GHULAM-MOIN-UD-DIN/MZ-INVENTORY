@extends('Layout.index')

@section('title', 'Add Purchase')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">New <span class="text-orange-500">Purchase</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Record a new stock acquisition from your suppliers.</p>
        </div>
        <a href="{{ route('purchase.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-500 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="premium-card p-8 stagger-1">
        <form action="{{ route('purchase.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="grand_total" value="0">
            <input type="hidden" name="payment_status" value="Paid">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Date -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Purchase Date *</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-input" required>
                </div>

                <!-- Supplier -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Supplier *</label>
                    <select name="supplier_id" class="form-input appearance-none" required>
                        <option value="" disabled selected>Select Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Warehouse -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Warehouse *</label>
                    <select name="warehouse_id" class="form-input appearance-none" required>
                        <option value="1">Main Warehouse</option>
                        <option value="2">Secondary Stock</option>
                    </select>
                </div>
            </div>

            <!-- Product Selection -->
            <div class="pt-8 border-t border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                        <i class="fas fa-magnifying-glass text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold uppercase tracking-widest">Select Products</h3>
                        <p class="text-xs text-slate-400">Add inventory items to this purchase order</p>
                    </div>
                </div>

                <div class="relative group">
                    <input type="text" placeholder="Search by SKU, name or scan barcode..." class="form-input pl-12 h-14 bg-slate-50 dark:bg-slate-900 border-none shadow-inner">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                </div>

                <!-- Items Table -->
                <div class="mt-8 overflow-hidden rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900">
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Product Info</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Unit Cost</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Quantity</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Subtotal</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">
                                    <i class="fas fa-cart-flatbed text-3xl mb-3 block opacity-20"></i>
                                    Waiting for product selection...
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-slate-50/50 dark:bg-slate-900/50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Order Total</td>
                                <td colspan="2" class="px-6 py-4 text-left">
                                    <span class="text-xl font-extrabold text-orange-500">Rs. 0.00</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Additional Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-100 dark:border-slate-800">
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Purchase Status *</label>
                    <select name="status" class="form-input appearance-none" required>
                        <option value="Received">Received & Stocked</option>
                        <option value="Pending">Pending / In Transit</option>
                        <option value="Ordered">Ordered / Awaiting Confirmation</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Internal Note</label>
                    <textarea name="note" rows="2" class="form-input" placeholder="Record any observations or instructions..."></textarea>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-8 flex justify-end gap-4">
                <button type="reset" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Discard
                </button>
                <button type="submit" class="btn-premium px-12 h-12">
                    <i class="fas fa-save"></i>
                    Save Purchase
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

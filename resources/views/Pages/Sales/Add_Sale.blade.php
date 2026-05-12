@extends('Layout.index')

@section('title', 'Add Sale')

@section('content')
<div class="max-w-6xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Create <span class="text-orange-500">Sale</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Generate a new sales invoice and process transaction.</p>
        </div>
        <a href="{{ route('sale.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-500 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Back to Sales
        </a>
    </div>

    <!-- Form Card -->
    <div class="premium-card p-8 stagger-1">
        <form action="{{ route('sale.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="grand_total" value="0">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <!-- Date -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Date *</label>
                    <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-input" required>
                </div>

                <!-- Customer -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Customer *</label>
                    <select name="customer_id" class="form-input appearance-none" required>
                        <option value="" disabled selected>Select Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
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

                <!-- Status -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Status *</label>
                    <select name="status" class="form-input appearance-none" required>
                        <option value="Completed">Completed</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>

            <!-- Product Search Section -->
            <div class="pt-8 border-t border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-4 mb-6">
                    <div class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                        <i class="fas fa-barcode text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-sm font-extrabold uppercase tracking-widest">Product Search</h3>
                        <p class="text-xs text-slate-400">Search products to add to this invoice</p>
                    </div>
                </div>

                <div class="relative group">
                    <input type="text" placeholder="Scan barcode or search by product name..." class="form-input pl-12 h-14 bg-slate-50 dark:bg-slate-900 border-none shadow-inner">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                </div>

                <!-- Order Items Table -->
                <div class="mt-8 overflow-hidden rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-900">
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400">Product Item</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Unit Price</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Quantity</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-center">Subtotal</th>
                                <th class="px-6 py-4 text-[10px] font-bold uppercase tracking-widest text-slate-400 text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50 dark:divide-slate-800">
                            <!-- Items placeholder -->
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-slate-400 font-bold uppercase tracking-widest text-[10px]">
                                    <i class="fas fa-shopping-basket text-3xl mb-3 block opacity-20"></i>
                                    No products selected
                                </td>
                            </tr>
                        </tbody>
                        <tfoot class="bg-slate-50/50 dark:bg-slate-900/50">
                            <tr>
                                <td colspan="3" class="px-6 py-4 text-right text-xs font-bold text-slate-500 uppercase tracking-widest">Grand Total</td>
                                <td colspan="2" class="px-6 py-4 text-left">
                                    <span class="text-xl font-extrabold text-orange-500">Rs. 0.00</span>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Footer Section -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-8 border-t border-slate-100 dark:border-slate-800">
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Payment Status *</label>
                    <select name="payment_status" class="form-input appearance-none" required>
                        <option value="Paid">Fully Paid</option>
                        <option value="Partial">Partial Payment</option>
                        <option value="Unpaid">Unpaid / Credit</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Sale Note</label>
                    <textarea name="note" rows="2" class="form-input" placeholder="Any additional information..."></textarea>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="pt-8 flex justify-end gap-4">
                <button type="reset" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Reset Form
                </button>
                <button type="submit" class="btn-premium px-12 h-12">
                    <i class="fas fa-check-circle"></i>
                    Complete Sale
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

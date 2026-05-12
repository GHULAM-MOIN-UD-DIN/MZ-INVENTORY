@extends('Layout.index')

@section('title', 'Create Return')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Create <span class="text-orange-500">Return</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Process a sale or purchase return and adjust stock levels.</p>
        </div>
        <a href="{{ route('return.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-500 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="premium-card p-8 stagger-1">
        <form action="{{ route('return.store') }}" method="POST" class="space-y-8">
            @csrf
            <input type="hidden" name="grand_total" value="0">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Date -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Return Date *</label>
                    <div class="relative">
                        <input type="date" name="date" value="{{ date('Y-m-d') }}" class="form-input pl-10" required>
                        <i class="fas fa-calendar absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <!-- Return Type -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Return Type *</label>
                    <select name="type" class="form-input appearance-none" required>
                        <option value="Sale Return">Sale Return (from Customer)</option>
                        <option value="Purchase Return">Purchase Return (to Supplier)</option>
                    </select>
                </div>

                <!-- Customer -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Customer</label>
                    <select name="customer_id" class="form-input appearance-none">
                        <option value="" selected>Select Customer (Optional)</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Supplier -->
                <div class="form-group">
                    <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Supplier</label>
                    <select name="supplier_id" class="form-input appearance-none">
                        <option value="" selected>Select Supplier (Optional)</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Notes -->
            <div class="form-group">
                <label class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-2">Reason / Observations</label>
                <div class="relative">
                    <textarea name="note" rows="4" class="form-input pl-10 pt-3" placeholder="Enter reason for return and any damaged stock notes..."></textarea>
                    <i class="fas fa-comment-dots absolute left-4 top-4 text-slate-400 text-xs"></i>
                </div>
            </div>

            <!-- Actions -->
            <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-4">
                <button type="reset" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Reset
                </button>
                <button type="submit" class="btn-premium px-12 h-12">
                    <i class="fas fa-undo-alt"></i>
                    Process Return
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

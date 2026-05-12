@extends('Layout.index')

@section('title', 'Add Supplier')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-orange-500">
                Add New Supplier
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Register a new vendor to your supply chain network.</p>
        </div>
        <a href="{{ route('supplier.index') }}" 
           class="group flex items-center gap-2 px-4 py-2 text-sm font-bold text-slate-600 dark:text-slate-400 
                  hover:text-orange-500 dark:hover:text-orange-400 bg-white dark:bg-slate-800 rounded-xl shadow-sm 
                  hover:shadow-md transition-all duration-300">
            <i class="fas fa-arrow-left group-hover:-translate-x-1 transition-transform"></i>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl shadow-slate-200/50 dark:shadow-slate-900/50 
                border border-slate-200/60 dark:border-slate-800/60 overflow-hidden stagger-1 animate-slide-up">
        
        <!-- Decorative Orange Bar -->
        <div class="h-2 bg-gradient-to-r from-orange-400 via-orange-500 to-orange-600"></div>
        
        <form action="{{ route('supplier.store') }}" method="POST" class="p-8 space-y-8" id="supplierForm">
            @csrf

            <!-- Vendor Information -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-building text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Vendor Information</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Basic identification and contact person</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">Supplier Name <span class="text-orange-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="name" class="form-input" placeholder="e.g. Acme Corp" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">Contact Person</label>
                        <div class="relative">
                            <input type="text" name="contact_person" class="form-input" placeholder="e.g. Jane Smith">
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">Email Address</label>
                        <div class="relative">
                            <input type="email" name="email" class="form-input" placeholder="e.g. vendor@example.com">
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">Phone Number</label>
                        <div class="relative">
                            <input type="text" name="phone" class="form-input" placeholder="e.g. +1 555 000 000">
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">City</label>
                        <div class="relative">
                            <input type="text" name="city" class="form-input" placeholder="e.g. London">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Office Location -->
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-map-location-dot text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Office Location</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Specify the primary office address</p>
                    </div>
                </div>

                <div class="form-group group">
                    <label class="form-label flex items-center gap-1">Office Address</label>
                    <div class="relative">
                        <textarea name="address" rows="3" class="form-input resize-none" placeholder="Enter complete office location..."></textarea>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-8 border-t-2 border-slate-100 dark:border-slate-800 flex justify-end gap-4">
                <button type="reset" class="px-8 py-3.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Reset Form
                </button>
                <button type="submit" class="px-10 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i>
                    Save Supplier
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('supplierForm').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i>Saving...';
    });
</script>
@endsection

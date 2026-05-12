@extends('Layout.index')

@section('title', 'Edit Supplier')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Edit <span class="text-orange-500">Supplier</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Update the details for your supply chain partner.</p>
        </div>
        <a href="{{ route('supplier.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-500 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="premium-card p-8 stagger-1">
        <form action="{{ route('supplier.update', $supplier->id) }}" method="POST" class="space-y-8">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Supplier Name *</label>
                    <div class="relative">
                        <input type="text" name="name" class="form-input pl-10" value="{{ $supplier->name }}" required>
                        <i class="fas fa-building absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <!-- Contact Person -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Contact Person</label>
                    <div class="relative">
                        <input type="text" name="contact_person" class="form-input pl-10" value="{{ $supplier->contact_person }}">
                        <i class="fas fa-user-tie absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" class="form-input pl-10" value="{{ $supplier->email }}">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Phone Number</label>
                    <div class="relative">
                        <input type="text" name="phone" class="form-input pl-10" value="{{ $supplier->phone }}">
                        <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <!-- City -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">City</label>
                    <div class="relative">
                        <input type="text" name="city" class="form-input pl-10" value="{{ $supplier->city }}">
                        <i class="fas fa-city absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Office Address</label>
                <div class="relative">
                    <textarea name="address" rows="3" class="form-input pl-10 pt-3" placeholder="Enter complete office location...">{{ $supplier->address }}</textarea>
                    <i class="fas fa-map-location-dot absolute left-4 top-4 text-slate-400 text-xs"></i>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-4">
                <a href="{{ route('supplier.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-10">
                    <i class="fas fa-save"></i>
                    Update Supplier
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

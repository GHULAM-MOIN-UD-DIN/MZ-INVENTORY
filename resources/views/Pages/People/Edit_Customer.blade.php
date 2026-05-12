@extends('Layout.index')

@section('title', 'Edit Customer')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight">Edit <span class="text-orange-500">Customer</span></h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Update the profile and contact details for this client.</p>
        </div>
        <a href="{{ route('customer.index') }}" class="flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-orange-500 transition-colors">
            <i class="fas fa-arrow-left"></i>
            Back to List
        </a>
    </div>

    <!-- Form Card -->
    <div class="premium-card p-8 stagger-1">
        <form action="{{ route('customer.update', $customer->id) }}" method="POST" class="space-y-8">
            @csrf
            <!-- Method is POST as per route, but usually Laravel uses PUT/PATCH. I'll stick to POST if that's what's in routes. -->

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Name -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Full Name *</label>
                    <div class="relative">
                        <input type="text" name="name" class="form-input pl-10" value="{{ $customer->name }}" required>
                        <i class="fas fa-user absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <!-- Email -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Email Address</label>
                    <div class="relative">
                        <input type="email" name="email" class="form-input pl-10" value="{{ $customer->email }}">
                        <i class="fas fa-envelope absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <!-- Phone -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Phone Number</label>
                    <div class="relative">
                        <input type="text" name="phone" class="form-input pl-10" value="{{ $customer->phone }}">
                        <i class="fas fa-phone absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>

                <!-- City -->
                <div class="form-group">
                    <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">City</label>
                    <div class="relative">
                        <input type="text" name="city" class="form-input pl-10" value="{{ $customer->city }}">
                        <i class="fas fa-city absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                    </div>
                </div>
            </div>

            <!-- Address -->
            <div class="form-group">
                <label class="block text-sm font-bold text-slate-700 dark:text-slate-300 mb-2">Complete Address</label>
                <div class="relative">
                    <textarea name="address" rows="3" class="form-input pl-10 pt-3" placeholder="Enter full postal address...">{{ $customer->address }}</textarea>
                    <i class="fas fa-location-dot absolute left-4 top-4 text-slate-400 text-xs"></i>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-8 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-4">
                <a href="{{ route('customer.index') }}" class="px-6 py-3 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Cancel
                </a>
                <button type="submit" class="btn-premium px-10">
                    <i class="fas fa-save"></i>
                    Update Customer
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@extends('Layout.index')

@section('title', 'Edit User')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-orange-500">
                Edit Staff Member
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Modify account details and access roles for staff.</p>
        </div>
        <a href="{{ route('user.index') }}" 
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
        
        <form action="{{ route('user.update', $user->id) }}" method="POST" class="p-8 space-y-8" id="userForm">
            @csrf

            <!-- Form Validation Errors -->
            @if ($errors->any())
                <div class="p-4 bg-red-500/10 border border-red-500/20 text-red-500 rounded-xl text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <p class="font-bold"><i class="fas fa-triangle-exclamation mr-1"></i>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Account Details -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-user-pen text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Account Details</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Basic identification and access credentials</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">Full Name <span class="text-orange-500">*</span></label>
                        <div class="relative">
                            <input type="text" name="name" class="form-input" placeholder="e.g. Farrukh Ali" required value="{{ old('name', $user->name) }}">
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">Email Address <span class="text-orange-500">*</span></label>
                        <div class="relative">
                            <input type="email" name="email" class="form-input" placeholder="e.g. farrukh@example.com" required value="{{ old('email', $user->email) }}">
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">Password</label>
                        <div class="relative">
                            <input type="password" name="password" class="form-input" placeholder="Leave blank to keep current password">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Role Selection Cards -->
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-shield-halved text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">System Role <span class="text-orange-500">*</span></h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Assign role and define access privileges</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Cashier Card -->
                    <label class="role-card cursor-pointer block">
                        <input type="radio" name="role" value="cashier" class="hidden" {{ old('role', $user->role) === 'cashier' ? 'checked' : '' }}>
                        <div class="role-card-inner p-6 rounded-2xl border-2 border-slate-200 dark:border-slate-800 transition-all flex flex-col h-full">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                                    <i class="fas fa-cash-register text-lg"></i>
                                </div>
                                <div class="role-dot w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-700 relative flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-white scale-0 transition-transform duration-200 absolute"></div>
                                </div>
                            </div>
                            <h4 class="font-extrabold text-base text-slate-800 dark:text-slate-200">Cashier</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Handles checkout, POS, billing, and sales. No settings or user management access.</p>
                        </div>
                    </label>

                    <!-- Manager Card -->
                    <label class="role-card cursor-pointer block">
                        <input type="radio" name="role" value="manager" class="hidden" {{ old('role', $user->role) === 'manager' ? 'checked' : '' }}>
                        <div class="role-card-inner p-6 rounded-2xl border-2 border-slate-200 dark:border-slate-800 transition-all flex flex-col h-full">
                            <div class="flex items-center justify-between mb-4">
                                <div class="w-12 h-12 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                                    <i class="fas fa-user-tie text-lg"></i>
                                </div>
                                <div class="role-dot w-5 h-5 rounded-full border-2 border-slate-300 dark:border-slate-700 relative flex items-center justify-center">
                                    <div class="w-2.5 h-2.5 rounded-full bg-white scale-0 transition-transform duration-200 absolute"></div>
                                </div>
                            </div>
                            <h4 class="font-extrabold text-base text-slate-800 dark:text-slate-200">Manager</h4>
                            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Manages inventory, categories, purchases, suppliers, and views reports. No settings or user access.</p>
                        </div>
                    </label>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="pt-8 border-t-2 border-slate-100 dark:border-slate-800 flex justify-end gap-4">
                <button type="reset" class="px-8 py-3.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Reset Form
                </button>
                <button type="submit" class="px-10 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i>
                    Update Staff Member
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .role-card input[type="radio"]:checked + .role-card-inner {
        border-color: #f97316;
        background: rgba(249, 115, 22, 0.02);
    }
    .role-card input[type="radio"]:checked + .role-card-inner .role-dot {
        background-color: #f97316;
        border-color: #f97316;
    }
    .role-card input[type="radio"]:checked + .role-card-inner .role-dot div {
        transform: scale(1) !important;
    }
</style>

<script>
    document.getElementById('userForm').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i>Saving...';
    });
</script>
@endsection

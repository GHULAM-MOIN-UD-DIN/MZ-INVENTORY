@extends('Layout.index')

@section('title', 'Profile Settings')

@section('content')
<div class="max-w-5xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl md:text-3xl font-extrabold tracking-tight text-orange-500">
                Profile Settings
            </h2>
            <p class="text-xs md:text-sm text-slate-500 dark:text-slate-400 mt-1">Manage your shop identity and personal profile.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-orange-500/10 border-l-4 border-orange-500 p-4 rounded-xl animate-slide-up mx-4 md:mx-0">
            <div class="flex items-center gap-3">
                <i class="fas fa-check-circle text-orange-500"></i>
                <p class="text-sm font-bold text-orange-700 dark:text-orange-400">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8 px-4 md:px-0">
        @csrf
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left Side: Shop & Profile -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Shop Settings -->
                @if(auth()->user()->role === 'admin')
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200/60 dark:border-slate-800/60 overflow-hidden stagger-1 animate-slide-up">
                    <div class="h-1.5 bg-gradient-to-r from-orange-400 to-orange-600"></div>
                    <div class="p-5 sm:p-8 space-y-6">
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
                            <div class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                                <i class="fas fa-shop text-sm md:text-lg"></i>
                            </div>
                            <h3 class="text-base md:text-lg font-bold">Shop Identity</h3>
                        </div>

                        <div class="form-group group">
                            <label class="form-label">Shop Name</label>
                            <input type="text" name="shop_name" class="form-input" value="{{ $user->shop_name }}" placeholder="e.g. My Store">
                        </div>

                        <div class="flex flex-col sm:flex-row sm:items-center gap-6">
                            <div class="space-y-1">
                                <label class="form-label">Shop Logo</label>
                                <p class="text-[10px] text-slate-400 uppercase font-bold tracking-widest">Recommended: Square PNG</p>
                            </div>
                            <div class="relative group cursor-pointer flex-1">
                                <input type="file" name="shop_logo" class="absolute inset-0 opacity-0 cursor-pointer z-10" onchange="previewImage(this, 'shopLogoPreview')">
                                <div class="px-6 py-4 border-2 border-dashed border-slate-200 dark:border-slate-800 rounded-xl flex items-center gap-4 group-hover:border-orange-500/50 transition-all">
                                    <div class="w-14 h-14 rounded-lg bg-slate-50 dark:bg-slate-800 overflow-hidden flex-shrink-0 border border-slate-100 dark:border-slate-800">
                                        @if($user->shop_logo)
                                            <img src="{{ cloudinary_url($user->shop_logo) }}" id="shopLogoPreview" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-slate-300" id="shopLogoPreview"><i class="fas fa-image text-xl"></i></div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-xs font-bold text-slate-700 dark:text-slate-200 uppercase">Change Logo</span>
                                        <span class="text-[10px] text-slate-400">Click to browse files</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- User Profile -->
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200/60 dark:border-slate-800/60 overflow-hidden stagger-2 animate-slide-up">
                    <div class="h-1.5 bg-gradient-to-r from-orange-400 to-orange-600"></div>
                    <div class="p-8 space-y-6">
                        <div class="flex items-center gap-3 pb-4 border-b border-slate-100 dark:border-slate-800">
                            <div class="w-10 h-10 rounded-xl bg-orange-500/10 text-orange-500 flex items-center justify-center">
                                <i class="fas fa-user-gear text-lg"></i>
                            </div>
                            <h3 class="text-lg font-bold">Your Profile</h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="form-group group">
                                <label class="form-label">Display Name</label>
                                <input type="text" name="name" class="form-input" value="{{ $user->name }}" required>
                            </div>
                            <div class="form-group group">
                                <label class="form-label">Email Address</label>
                                <input type="email" name="email" class="form-input" value="{{ $user->email }}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Side: Preview & Profile Photo -->
            <div class="space-y-8 stagger-3 animate-slide-up">
                <div class="bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200/60 dark:border-slate-800/60 overflow-hidden">
                    <div class="p-8 text-center space-y-6">
                        <label class="form-label block text-center mb-4">Profile Photo</label>
                        <div class="relative inline-block group">
                            <div class="w-32 h-32 rounded-3xl overflow-hidden border-4 border-white dark:border-slate-800 shadow-2xl mx-auto ring-4 ring-orange-500/20">
                                @if($user->photo)
                                    <img src="{{ cloudinary_url($user->photo) }}" class="w-full h-full object-cover" id="adminPhotoPreview">
                                @else
                                    <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ urlencode($user->name) }}" class="w-full h-full object-cover" id="adminPhotoPreview">
                                @endif
                            </div>
                            <label class="absolute -bottom-2 -right-2 w-10 h-10 bg-orange-500 text-white rounded-xl flex items-center justify-center shadow-lg cursor-pointer hover:scale-110 transition-transform border-4 border-white dark:border-slate-900">
                                <i class="fas fa-camera text-sm"></i>
                                <input type="file" name="photo" class="hidden" onchange="previewImage(this, 'adminPhotoPreview')">
                            </label>
                        </div>
                        
                        <div class="pt-4">
                            <h4 class="font-extrabold text-xl">{{ $user->name }}</h4>
                            <p class="text-xs text-slate-400 mt-1">{{ $user->email }}</p>
                            <p class="text-[10px] text-orange-500 font-bold uppercase tracking-widest mt-1">{{ $user->role === 'admin' ? 'Super Administrator' : ucfirst($user->role) }}</p>
                        </div>

                        <div class="pt-6">
                            <button type="submit" class="w-full py-4 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-500/30 transition-all transform hover:-translate-y-1">
                                <i class="fas fa-save mr-2"></i> Save Changes
                            </button>
                        </div>
                    </div>
                </div>

                <div class="p-6 bg-orange-500/5 rounded-2xl border border-orange-500/10">
                    <p class="text-xs text-orange-600 dark:text-orange-400 leading-relaxed font-medium">
                        <i class="fas fa-info-circle mr-1"></i> These settings control your personal profile and shop branding displayed in the sidebar. Each user has their own independent settings.
                    </p>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection

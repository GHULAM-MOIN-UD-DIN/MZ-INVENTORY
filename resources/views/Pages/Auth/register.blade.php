<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | MZ Inventory Pro</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind & Font Awesome & SweetAlert2 -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fff7ed', 100: '#ffedd5', 200: '#fed7aa', 300: '#fdba74',
                            400: '#fb923c', 500: '#f97316', 600: '#ea580c', 700: '#c2410c',
                            800: '#9a3412', 900: '#7c2d12',
                        }
                    },
                    fontFamily: {
                        'sans': ['Outfit', 'ui-sans-serif'],
                        'display': ['Plus Jakarta Sans', 'ui-sans-serif'],
                    },
                    animation: {
                        'pulse-slow': 'pulseSlow 8s infinite ease-in-out',
                        'float': 'float 6s ease-in-out infinite',
                        'fade-in': 'fadeIn 0.8s ease-out both',
                        'slide-up': 'slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) both',
                    },
                    keyframes: {
                        pulseSlow: {
                            '0%, 100%': { transform: 'scale(1) translate(0, 0)', opacity: '0.4' },
                            '50%': { transform: 'scale(1.15) translate(3%, 5%)', opacity: '0.6' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)' },
                            '50%': { transform: 'translateY(-15px) rotate(3deg)' }
                        },
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { transform: 'translateY(30px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } }
                    }
                }
            }
        }
    </script>

    <style>
        .glass-panel {
            background: rgba(15, 23, 42, 0.65);
            backdrop-filter: blur(20px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
        }
        .form-input-premium {
            background: rgba(30, 41, 59, 0.5);
            border: 2px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .form-input-premium:focus {
            border-color: #f97316;
            background: rgba(15, 23, 42, 0.8);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.15);
            outline: none;
        }
    </style>
</head>

<body class="bg-[#020617] text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden font-sans antialiased">

    <!-- Ambient Glowing Orbs in Background -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-orange-600/20 rounded-full filter blur-[120px] animate-pulse-slow"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-brand-800/20 rounded-full filter blur-[120px] animate-pulse-slow" style="animation-delay: 4s;"></div>
    <div class="absolute top-1/2 left-1/3 w-80 h-80 bg-orange-500/10 rounded-full filter blur-[100px] animate-pulse-slow" style="animation-delay: 2s;"></div>

    <!-- Register Container -->
    <div class="w-full max-w-[500px] relative z-10 animate-slide-up my-8">
        
        <!-- Brand identity logo -->
        <div class="text-center mb-8 animate-float">
            <div class="inline-flex w-16 h-16 bg-gradient-to-tr from-orange-600 to-orange-400 rounded-2xl items-center justify-center shadow-2xl shadow-orange-500/30 overflow-hidden mb-3">
                @if($settings && $settings->shop_logo)
                    <img src="{{ cloudinary_url($settings->shop_logo) }}" class="w-full h-full object-cover">
                @else
                    <span class="text-white font-extrabold text-2xl">MZ</span>
                @endif
            </div>
            <h1 class="font-display font-black text-2xl tracking-tight leading-none text-white">
                {{ explode(' ', $settings->shop_name ?? 'MZ Inventory')[0] }}
                <span class="text-orange-500">{{ explode(' ', $settings->shop_name ?? 'MZ Inventory')[1] ?? 'Inventory' }}</span>
            </h1>
            <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-[0.25em] font-bold mt-2">Create your administrator or staff account</p>
        </div>

        <!-- Glassmorphic Form Card -->
        <div class="glass-panel rounded-3xl p-8 sm:p-10 relative overflow-hidden">
            <!-- Subtle Orange Top Line -->
            <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-orange-500 to-orange-600"></div>

            <div class="mb-8">
                <h2 class="text-xl font-bold text-white">Get Started</h2>
                <p class="text-xs text-slate-400 mt-1">Register a new profile in seconds.</p>
            </div>

            <!-- Registration Form -->
            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <!-- Name Input -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Full Name</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-orange-500 transition-colors">
                            <i class="fas fa-user"></i>
                        </span>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="John Doe"
                               class="form-input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm text-white placeholder-slate-500">
                    </div>
                </div>

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Email Address</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-orange-500 transition-colors">
                            <i class="fas fa-envelope"></i>
                        </span>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="your.name@example.com"
                               class="form-input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm text-white placeholder-slate-500">
                    </div>
                </div>

                <!-- Role Selection -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">System Role</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-orange-500 transition-colors">
                            <i class="fas fa-user-tag text-xs"></i>
                        </span>
                        <select name="role" required class="form-input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm text-slate-300 appearance-none cursor-pointer">
                            <option value="admin" class="bg-slate-900 text-white">Administrator (Full Access)</option>
                            <option value="manager" class="bg-slate-900 text-white">Manager (Moderate Access)</option>
                            <option value="cashier" class="bg-slate-900 text-white" selected>Cashier (Limited Access)</option>
                        </select>
                        <span class="absolute inset-y-0 right-0 pr-4 flex items-center text-slate-400 pointer-events-none">
                            <i class="fas fa-chevron-down text-xs"></i>
                        </span>
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Password</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-orange-500 transition-colors">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="password" required placeholder="Min. 8 characters"
                               class="form-input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm text-white placeholder-slate-500">
                    </div>
                </div>

                <!-- Confirm Password Input -->
                <div class="space-y-1.5">
                    <label class="block text-xs font-bold text-slate-300 uppercase tracking-wider">Confirm Password</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-400 group-focus-within:text-orange-500 transition-colors">
                            <i class="fas fa-shield-halved"></i>
                        </span>
                        <input type="password" name="password_confirmation" required placeholder="Repeat password"
                               class="form-input-premium w-full pl-11 pr-4 py-3 rounded-xl text-sm text-white placeholder-slate-500">
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-500/20 transition-all transform hover:-translate-y-0.5 active:translate-y-0 flex items-center justify-center gap-2 mt-2">
                    <i class="fas fa-user-plus"></i> Create Account
                </button>
            </form>

            <!-- Registration Redirect Link -->
            <div class="mt-6 text-center border-t border-slate-800 pt-5">
                <p class="text-xs text-slate-400 font-medium">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-orange-500 font-bold hover:text-orange-400 transition-colors ml-1">Sign In</a>
                </p>
            </div>
        </div>
        
        <!-- Footer info -->
        <p class="text-center text-[10px] text-slate-500 uppercase tracking-widest mt-8 font-bold">&copy; 2026 MZ Inventory Pro &bull; All Rights Reserved</p>
    </div>

    <!-- SweetAlert notifications -->
    <script>
        @if($errors->any())
            Swal.fire({ 
                icon: 'error', 
                title: 'Registration Error', 
                html: '<ul class="text-left text-xs space-y-1">@foreach($errors->all() as $error)<li><i class="fas fa-exclamation-circle text-orange-500 mr-2"></i>{{ $error }}</li>@endforeach</ul>', 
                confirmButtonColor: '#f97316',
                background: '#0f172a',
                color: '#f8fafc'
            });
        @endif
    </script>
</body>
</html>

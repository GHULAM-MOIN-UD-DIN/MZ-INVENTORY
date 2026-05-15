<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | MZ Inventory</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Tailwind & Font Awesome & ApexCharts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>
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
                        'fade-in': 'fadeIn 0.6s ease-out both',
                        'slide-up': 'slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both',
                        'gps-pulse': 'gpsPulse 2s infinite',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { transform: 'translateY(15px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } },
                        gpsPulse: {
                            '0%': { boxShadow: '0 0 0 0 rgba(249, 115, 22, 0.7)' },
                            '70%': { boxShadow: '0 0 0 10px rgba(249, 115, 22, 0)' },
                            '100%': { boxShadow: '0 0 0 0 rgba(249, 115, 22, 0)' }
                        },
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-5px)' } },
                    },
                }
            }
        }
    </script>

    <style>
        :root {
            --w-sidebar: 280px;
            --h-navbar: 70px;
            --transition-main: 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            --bg-page: #ffffff;
            --bg-sidebar: #ffffff;
            --bg-card: #ffffff;
            --bg-input: #f8fafc;
            --border-color: rgba(0, 0, 0, 0.05);
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --brand-primary: #f97316;
            --brand-secondary: #fb923c;
            --shadow-premium: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        }

        .dark {
            --bg-page: #020617;
            --bg-sidebar: #0f172a;
            --bg-card: #0f172a;
            --bg-input: #1e293b;
            --border-color: rgba(255, 255, 255, 0.05);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
            --shadow-premium: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(0, 0, 0, 0.4);
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-primary);
            transition: background-color var(--transition-main), color var(--transition-main);
            overflow-x: hidden;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--brand-primary); border-radius: 20px; }

        .glass {
            backdrop-filter: blur(12px) saturate(180%);
            background: rgba(255, 255, 255, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        .dark .glass {
            background: rgba(15, 23, 42, 0.75);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        #sidebar {
            width: var(--w-sidebar); height: 100vh; position: fixed; top: 0; left: 0; z-index: 50;
            background: var(--bg-sidebar); border-right: 1px solid var(--border-color);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            overflow: hidden;
        }

        body.mini-sidebar {
            --w-sidebar: 80px;
        }

        .mini-sidebar #sidebar span, 
        .mini-sidebar #sidebar .sub-link,
        .mini-sidebar #sidebar p,
        .mini-sidebar #sidebar .flex-1.overflow-hidden {
            display: none;
        }

        .mini-sidebar #sidebar .nav-link {
            padding: 0.75rem;
            justify-content: center;
        }

        .mini-sidebar #sidebar .nav-link i {
            margin-right: 0;
        }

        .mini-sidebar #sidebar .p-6.flex.items-center.justify-between.gap-3 {
            padding: 1.5rem 0.5rem;
            justify-content: center;
        }

        .mini-sidebar #sidebar h1, 
        .mini-sidebar #sidebar .lg\:hidden {
            display: none;
        }

        .main-content {
            margin-left: 0;
            width: 100%;
            overflow-x: hidden;
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @media (min-width: 1024px) {
            .main-content {
                margin-left: var(--w-sidebar);
                width: calc(100% - var(--w-sidebar));
            }
        }

        .nav-link {
            display: flex; align-items: center; padding: 0.75rem 1rem; margin: 0.25rem 1rem; border-radius: 12px;
            color: var(--text-secondary); font-weight: 500; transition: all 0.2s ease;
        }

        .nav-link i {
            width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;
            border-radius: 8px; margin-right: 0.75rem; background: transparent; transition: all 0.2s ease;
        }

        .nav-link:hover, .nav-link.active {
            color: var(--brand-primary); background: rgba(249, 115, 22, 0.08);
        }

        .nav-link.active i, .nav-link:hover i {
            background: var(--brand-primary); color: white; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .premium-card {
            background: var(--bg-card); border: 1px solid var(--border-color); border-radius: 20px;
            box-shadow: var(--shadow-premium); transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .premium-card:hover { transform: translateY(-5px); box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.08); }

        .btn-premium {
            background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary)); color: white;
            padding: 0.75rem 1.5rem; border-radius: 12px; font-weight: 600; display: inline-flex; align-items: center;
            justify-content: center; gap: 0.5rem; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(249, 115, 22, 0.3);
        }

        .gps-dot {
            width: 8px; height: 8px; background: var(--brand-primary); border-radius: 50%;
            display: inline-block; position: relative;
        }
        .gps-dot::after {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            border-radius: 50%; background: var(--brand-primary); animation: gpsPulse 2s infinite;
        }

        .sub-link {
            display: block; padding: 0.5rem 1rem 0.5rem 3.5rem; font-size: 0.85rem; color: var(--text-secondary);
            transition: all 0.2s ease; border-radius: 8px; margin: 0.1rem 1rem;
        }
        .sub-link:hover { color: var(--brand-primary); background: rgba(249, 115, 22, 0.05); }
        .sub-link.active { color: var(--brand-primary); font-weight: 600; }

        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 12px;
            background: var(--bg-input);
            border: 2px solid var(--border-color);
            color: var(--text-primary);
            transition: all 0.3s ease;
        }
        .form-input:focus {
            outline: none;
            border-color: var(--brand-primary);
            background: var(--bg-card);
            box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.1);
        }
    </style>
    @stack('styles')
</head>

<body class="antialiased">

    <div id="loader" class="fixed inset-0 z-[100] flex flex-col items-center justify-center bg-white dark:bg-slate-950 transition-opacity duration-500">
        <div class="relative w-24 h-24">
            <div class="absolute inset-0 border-4 border-orange-100 dark:border-slate-800 rounded-full"></div>
            <div class="absolute inset-0 border-4 border-orange-500 rounded-full border-t-transparent animate-spin"></div>
            <div class="absolute inset-0 flex items-center justify-center font-bold text-orange-500 text-xl">MZ</div>
        </div>
        <p class="mt-4 font-display font-bold text-slate-900 dark:text-white tracking-widest uppercase text-xs">Inventory Pro</p>
    </div>

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" onclick="toggleSidebar()" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-40 hidden lg:hidden transition-opacity duration-300"></div>

    <aside id="sidebar" class="fixed top-0 left-0 z-50 h-screen transition-transform duration-300 -translate-x-full lg:translate-x-0 w-[280px]">
        <div class="flex flex-col h-full">
            <div class="p-6 flex items-center justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-gradient-to-tr from-orange-600 to-orange-400 rounded-xl flex items-center justify-center shadow-lg shadow-orange-500/30 animate-float overflow-hidden">
                        @if($settings && $settings->shop_logo)
                            <img src="{{ ($settings && $settings->shop_logo) ? Storage::url($settings->shop_logo) : 'https://api.dicebear.com/7.x/shapes/svg?seed=Inventory' }}" class="w-full h-full object-cover">
                        @else
                            <span class="text-white font-extrabold text-lg">{{ substr($settings->shop_name ?? 'MZ', 0, 2) }}</span>
                        @endif
                    </div>
                    <div>
                        <h1 class="font-display font-extrabold text-lg leading-none tracking-tight">
                            {{ explode(' ', $settings->shop_name ?? 'MZ Inventory')[0] }} 
                            <span class="text-orange-500">{{ explode(' ', $settings->shop_name ?? 'MZ Inventory')[1] ?? '' }}</span>
                        </h1>
                        <p class="text-[10px] text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] font-bold mt-1">Management</p>
                    </div>
                </div>
                <!-- Close Button (Mobile Only) -->
                <button onclick="toggleSidebar()" class="lg:hidden w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 flex items-center justify-center hover:bg-orange-500 hover:text-white transition-all">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto py-4">
                <div class="px-6 mb-2"><p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Main Menu</p></div>
                <a href="/" class="nav-link {{ request()->is('/') ? 'active' : '' }}"><i class="fas fa-gauge-high"></i><span>Dashboard</span></a>
                <a href="{{ route('pos.index') }}" class="nav-link {{ request()->is('pos*') ? 'active' : '' }}"><i class="fas fa-cash-register text-orange-500"></i><span class="text-orange-500 font-black">Point of Sale</span></a>

                <!-- Inventory Dropdown -->
                <div class="px-6 mt-6 mb-2"><p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Inventory</p></div>
                <div class="group">
                    <button onclick="toggleSubmenu('products-sub')" class="nav-link w-[calc(100%-2rem)] flex justify-between {{ request()->is('products*') ? 'active' : '' }}">
                        <div class="flex items-center"><i class="fas fa-boxes-stacked"></i><span>Products</span></div>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" id="products-sub-icon"></i>
                    </button>
                    <div id="products-sub" class="{{ request()->is('products*') ? '' : 'hidden' }} py-1">
                        <a href="{{ route('product.index') }}" class="sub-link {{ request()->is('products') ? 'active' : '' }}">All Products</a>
                        <a href="{{ route('product.create') }}" class="sub-link {{ request()->is('products/add') ? 'active' : '' }}">Add Product</a>
                    </div>
                </div>

                <div class="group">
                    <button onclick="toggleSubmenu('cats-sub')" class="nav-link w-[calc(100%-2rem)] flex justify-between {{ request()->is('categories*') ? 'active' : '' }}">
                        <div class="flex items-center"><i class="fas fa-tags"></i><span>Categories</span></div>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" id="cats-sub-icon"></i>
                    </button>
                    <div id="cats-sub" class="{{ request()->is('categories*') ? '' : 'hidden' }} py-1">
                        <a href="{{ route('category.index') }}" class="sub-link {{ request()->is('categories') ? 'active' : '' }}">All Categories</a>
                        <a href="{{ route('category.create') }}" class="sub-link {{ request()->is('categories/add') ? 'active' : '' }}">Add Category</a>
                    </div>
                </div>

                <!-- Transactions Dropdown -->
                <div class="px-6 mt-6 mb-2"><p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Transactions</p></div>
                <div class="group">
                    <button onclick="toggleSubmenu('sales-sub')" class="nav-link w-[calc(100%-2rem)] flex justify-between {{ request()->is('sales*') ? 'active' : '' }}">
                        <div class="flex items-center"><i class="fas fa-receipt"></i><span>Sales</span></div>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" id="sales-sub-icon"></i>
                    </button>
                    <div id="sales-sub" class="{{ request()->is('sales*') ? '' : 'hidden' }} py-1">
                        <a href="{{ route('sale.index') }}" class="sub-link {{ request()->is('sales') ? 'active' : '' }}">Sales History</a>
                        <a href="{{ route('sale.create') }}" class="sub-link {{ request()->is('sales/add') ? 'active' : '' }}">Create Sale</a>
                    </div>
                </div>

                <div class="group">
                    <button onclick="toggleSubmenu('purchases-sub')" class="nav-link w-[calc(100%-2rem)] flex justify-between {{ request()->is('purchases*') ? 'active' : '' }}">
                        <div class="flex items-center"><i class="fas fa-cart-shopping"></i><span>Purchases</span></div>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" id="purchases-sub-icon"></i>
                    </button>
                    <div id="purchases-sub" class="{{ request()->is('purchases*') ? '' : 'hidden' }} py-1">
                        <a href="{{ route('purchase.index') }}" class="sub-link {{ request()->is('purchases') ? 'active' : '' }}">Purchase History</a>
                        <a href="{{ route('purchase.create') }}" class="sub-link {{ request()->is('purchases/add') ? 'active' : '' }}">Create Purchase</a>
                    </div>
                </div>

                <!-- People Dropdown -->
                <div class="px-6 mt-6 mb-2"><p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">People & Reports</p></div>
                <div class="group">
                    <button onclick="toggleSubmenu('people-sub')" class="nav-link w-[calc(100%-2rem)] flex justify-between {{ request()->is('customers*') || request()->is('suppliers*') ? 'active' : '' }}">
                        <div class="flex items-center"><i class="fas fa-user-group"></i><span>People</span></div>
                        <i class="fas fa-chevron-down text-[10px] transition-transform duration-200" id="people-sub-icon"></i>
                    </button>
                    <div id="people-sub" class="{{ request()->is('customers*') || request()->is('suppliers*') ? '' : 'hidden' }} py-1">
                        <a href="{{ route('customer.index') }}" class="sub-link {{ request()->is('customers*') ? 'active' : '' }}">Customers</a>
                        <a href="{{ route('supplier.index') }}" class="sub-link {{ request()->is('suppliers*') ? 'active' : '' }}">Suppliers</a>
                    </div>
                </div>

                <a href="{{ route('report.index') }}" class="nav-link {{ request()->is('reports*') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i><span>Reports</span>
                </a>

                <!-- App Settings -->
                <div class="px-6 mt-6 mb-2"><p class="text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-widest">Configuration</p></div>
                <a href="{{ route('setting.index') }}" class="nav-link {{ request()->is('settings*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i><span>App Settings</span>
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100 dark:border-slate-800">
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-900/50 border border-slate-100 dark:border-slate-800">
                    <div class="w-10 h-10 rounded-xl bg-orange-500 flex items-center justify-center text-white font-bold shadow-md shadow-orange-500/20 overflow-hidden">
                        @if($settings && $settings->admin_photo)
                            <img src="{{ ($settings && $settings->admin_photo) ? Storage::url($settings->admin_photo) : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . ($settings->admin_name ?? 'Admin') }}" class="w-full h-full object-cover">
                        @else
                            {{ substr($settings->admin_name ?? 'Admin', 0, 2) }}
                        @endif
                    </div>
                    <div class="flex-1 overflow-hidden">
                        <p class="text-sm font-bold truncate">{{ $settings->admin_name ?? 'Maz Admin' }}</p>
                        <p class="text-[10px] text-orange-500 font-bold uppercase tracking-tight">Super Admin</p>
                    </div>
                    <div class="gps-dot"></div>
                </div>
            </div>
        </div>
    </aside>

    <div class="main-content min-h-screen flex flex-col">
        <!-- Restored Header to Turn 8 Version -->
        <header class="h-[70px] sticky top-0 z-40 flex items-center justify-between px-6 glass border-b border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-4 animate-fade-in">
                <button onclick="toggleSidebar()" class="lg:hidden w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-orange-500 transition-all"><i class="fas fa-bars"></i></button>
                <button onclick="toggleMiniSidebar()" class="hidden lg:flex w-10 h-10 rounded-xl items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:text-orange-500 transition-all shadow-sm"><i class="fas fa-bars-staggered"></i></button>
                <div class="hidden md:flex items-center gap-2 text-sm">
                    <span class="text-slate-400"><i class="fas fa-house"></i></span>
                    <i class="fas fa-chevron-right text-[10px] text-slate-300"></i>
                    <span class="font-semibold text-orange-500">@yield('title')</span>
                </div>
            </div>

            <div class="flex items-center gap-4 animate-fade-in">
                <!-- Restored Search Box -->
                <div class="hidden md:block relative">
                    <input type="text" placeholder="Search data..." class="w-64 bg-slate-100 dark:bg-slate-800/50 border-none rounded-xl py-2 pl-10 pr-4 text-sm focus:ring-2 focus:ring-orange-500/20 transition-all">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                </div>

                <button onclick="toggleTheme()" id="theme-toggle" class="w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 transition-all hover:bg-orange-100 hover:text-orange-600 dark:hover:bg-orange-950 dark:hover:text-orange-400">
                    <i class="fas fa-moon" id="theme-icon"></i>
                </button>

                <!-- Restored Notifications -->
                <button class="relative w-10 h-10 rounded-xl flex items-center justify-center bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300">
                    <i class="fas fa-bell"></i>
                    <span class="absolute top-2.5 right-2.5 w-2 h-2 bg-orange-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                </button>

                <div class="h-8 w-[1px] bg-slate-200 dark:bg-slate-800 mx-1"></div>
                
                <div class="flex items-center gap-3 cursor-pointer group" onclick="window.location.href='{{ route('setting.index') }}'">
                    <div class="hidden text-right lg:block">
                        <p class="text-xs font-bold leading-none">{{ $settings->admin_name ?? 'Maz Admin' }}</p>
                        <p class="text-[10px] text-slate-400 mt-1">{{ $settings->admin_email ?? 'admin@example.com' }}</p>
                    </div>
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-slate-200 to-slate-300 dark:from-slate-700 dark:to-slate-800 border-2 border-white dark:border-slate-800 overflow-hidden shadow-sm">
                        @if($settings && $settings->admin_photo)
                            <img src="{{ ($settings && $settings->admin_photo) ? Storage::url($settings->admin_photo) : 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . ($settings->admin_name ?? 'Admin') }}" class="w-full h-full object-cover">
                        @else
                            <img src="https://api.dicebear.com/7.x/avataaars/svg?seed={{ $settings->admin_name ?? 'Admin' }}" alt="User">
                        @endif
                    </div>
                </div>
            </div>
        </header>

        <main class="flex-1 p-6 lg:p-10 animate-fade-in">@yield('content')</main>

        <footer class="p-6 text-center text-[10px] font-bold text-slate-400 uppercase tracking-widest border-t border-slate-100 dark:border-slate-800">
            <p>&copy; 2026 MZ Inventory Pro &bull; Built with <i class="fas fa-heart text-orange-500"></i></p>
        </footer>
    </div>

    <a href="{{ route('product.create') }}" class="fixed bottom-8 right-8 w-14 h-14 bg-orange-500 text-white rounded-2xl flex items-center justify-center shadow-xl shadow-orange-500/40 hover:scale-110 hover:rotate-90 transition-all duration-300 z-50 animate-float"><i class="fas fa-plus text-xl"></i></a>

    <script>
        window.addEventListener('load', () => {
            const loader = document.getElementById('loader');
            loader.style.opacity = '0';
            setTimeout(() => loader.style.display = 'none', 500);
        });

        const html = document.documentElement;
        const themeIcon = document.getElementById('theme-icon');
        
        function toggleTheme() {
            if (html.classList.contains('dark')) {
                html.classList.remove('dark');
                themeIcon.classList.replace('fa-sun', 'fa-moon');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                themeIcon.classList.replace('fa-moon', 'fa-sun');
                localStorage.setItem('theme', 'dark');
            }
        }

        if (localStorage.getItem('theme') === 'dark' || (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            html.classList.add('dark');
            themeIcon.classList.replace('fa-moon', 'fa-sun');
        }

        function toggleSidebar() { 
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebar-overlay');
            sidebar.classList.toggle('-translate-x-full'); 
            overlay.classList.toggle('hidden');
        }

        function toggleMiniSidebar() {
            document.body.classList.toggle('mini-sidebar');
            localStorage.setItem('miniSidebar', document.body.classList.contains('mini-sidebar'));
        }

        if (localStorage.getItem('miniSidebar') === 'true') {
            document.body.classList.add('mini-sidebar');
        }

        function toggleSubmenu(id) {
            const sub = document.getElementById(id);
            const icon = document.getElementById(id + '-icon');
            sub.classList.toggle('hidden');
            icon.classList.toggle('rotate-180');
        }
    </script>
    <script>
        @if(session('success'))
            Swal.fire({ icon: 'success', title: 'Success!', text: "{{ session('success') }}", confirmButtonColor: '#f97316' });
        @endif
        @if($errors->any())
            Swal.fire({ 
                icon: 'error', 
                title: 'Validation Error', 
                html: '<ul class="text-left">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>', 
                confirmButtonColor: '#f97316' 
            });
        @endif
    </script>
</body>

</html>
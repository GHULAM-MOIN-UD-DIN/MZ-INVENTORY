<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product ? $product->name . ' | Product Details' : 'Product Not Found' }}</title>
    <meta name="description" content="{{ $product ? 'View details for ' . $product->name : 'Product not found' }}">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Tailwind & Font Awesome -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.5/dist/JsBarcode.all.min.js"></script>

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        'sans': ['Outfit', 'ui-sans-serif'],
                        'display': ['Plus Jakarta Sans', 'ui-sans-serif'],
                    },
                    animation: {
                        'fade-in': 'fadeIn 0.6s ease-out both',
                        'slide-up': 'slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) both',
                        'float': 'float 3s ease-in-out infinite',
                    },
                    keyframes: {
                        fadeIn: { '0%': { opacity: '0' }, '100%': { opacity: '1' } },
                        slideUp: { '0%': { transform: 'translateY(15px)', opacity: '0' }, '100%': { transform: 'translateY(0)', opacity: '1' } },
                        float: { '0%, 100%': { transform: 'translateY(0)' }, '50%': { transform: 'translateY(-5px)' } },
                    },
                }
            }
        }
    </script>

    <style>
        :root {
            --bg-page: #f8fafc;
            --bg-card: #ffffff;
            --border-color: rgba(0, 0, 0, 0.05);
            --text-primary: #0f172a;
            --text-secondary: #64748b;
            --brand-primary: #f97316;
        }

        .dark {
            --bg-page: #020617;
            --bg-card: #0f172a;
            --border-color: rgba(255, 255, 255, 0.05);
            --text-primary: #f8fafc;
            --text-secondary: #94a3b8;
        }

        body {
            background-color: var(--bg-page);
            color: var(--text-primary);
            font-family: 'Outfit', sans-serif;
        }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--brand-primary); border-radius: 20px; }

        .premium-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.04), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
        }

        .dark .premium-card {
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.5), 0 10px 10px -5px rgba(0, 0, 0, 0.4);
        }

        @keyframes shimmer {
            0% { background-position: -200% 0; }
            100% { background-position: 200% 0; }
        }

        .shimmer-bg {
            background: linear-gradient(90deg, transparent 0%, rgba(249, 115, 22, 0.08) 50%, transparent 100%);
            background-size: 200% 100%;
            animation: shimmer 3s infinite;
        }
    </style>
</head>

<body class="antialiased min-h-screen">
    <!-- Theme Toggle (Top Right) -->
    <div class="fixed top-4 right-4 z-50">
        <button onclick="toggleTheme()" id="theme-toggle" class="w-10 h-10 rounded-xl flex items-center justify-center bg-white dark:bg-slate-800 text-slate-600 dark:text-slate-300 transition-all hover:bg-orange-100 hover:text-orange-600 dark:hover:bg-orange-950 dark:hover:text-orange-400 shadow-lg border border-slate-100 dark:border-slate-700">
            <i class="fas fa-moon" id="theme-icon"></i>
        </button>
    </div>

    <div class="max-w-2xl mx-auto px-4 py-8 sm:py-12 animate-fade-in">

        @if($product)
            <!-- Product Header -->
            <div class="premium-card overflow-hidden animate-slide-up">
                <!-- Gradient Header -->
                <div class="bg-gradient-to-r from-orange-500 via-orange-400 to-amber-400 p-5 sm:p-6 text-white">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-box-open text-xl sm:text-2xl"></i>
                        </div>
                        <div class="min-w-0">
                            <h1 class="text-lg sm:text-2xl font-extrabold tracking-tight truncate">{{ $product->name }}</h1>
                            <p class="text-white/80 text-xs sm:text-sm font-medium mt-0.5">Product Code: <span class="font-bold text-white">{{ $product->code }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="p-5 sm:p-8 space-y-6">
                    <!-- Product Image -->
                    <div class="w-full aspect-video sm:aspect-[16/9] rounded-2xl overflow-hidden bg-slate-100 dark:bg-slate-800 border-2 border-slate-100 dark:border-slate-800">
                        @if($product->image)
                            <img src="{{ cloudinary_url($product->image) }}" class="w-full h-full object-cover" alt="{{ $product->name }}">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center bg-gradient-to-br from-orange-50 to-orange-100 dark:from-slate-800 dark:to-slate-900">
                                <i class="fas fa-box text-5xl sm:text-6xl text-orange-300 dark:text-orange-500/30 mb-3"></i>
                                <span class="text-orange-400 text-xs font-bold uppercase tracking-widest">No Image Available</span>
                            </div>
                        @endif
                    </div>

                    <!-- Tags -->
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1.5 rounded-lg bg-orange-500/10 text-orange-600 dark:text-orange-400 text-[10px] sm:text-xs font-extrabold uppercase tracking-wider">
                            {{ $product->category->name ?? 'N/A' }}
                        </span>
                        <span class="px-3 py-1.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-500 text-[10px] sm:text-xs font-extrabold uppercase tracking-wider">
                            {{ $product->type }}
                        </span>
                    </div>

                    <!-- Description -->
                    @if($product->description)
                        <div class="shimmer-bg rounded-2xl p-4 sm:p-5 border border-slate-100 dark:border-slate-800">
                            <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-2">
                                <i class="fas fa-align-left text-orange-500 mr-1"></i> Description
                            </p>
                            <p class="text-slate-600 dark:text-slate-300 text-sm leading-relaxed">{{ $product->description }}</p>
                        </div>
                    @endif

                    <!-- Selling Price -->
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100/50 dark:from-orange-950/30 dark:to-orange-900/10 rounded-2xl p-5 sm:p-6 text-center border border-orange-100 dark:border-orange-900/30">
                        <div class="w-14 h-14 bg-orange-500 rounded-2xl flex items-center justify-center mx-auto mb-3 shadow-lg shadow-orange-500/25">
                            <i class="fas fa-tag text-white text-xl"></i>
                        </div>
                        <p class="text-[9px] text-slate-400 font-extrabold uppercase tracking-widest mb-2">Selling Price</p>
                        <p class="text-3xl sm:text-4xl font-black text-orange-600 dark:text-orange-400">
                            Rs. {{ number_format($product->price, 2) }}
                        </p>
                    </div>

                    <!-- Availability Badge -->
                    <div class="flex justify-center">
                        @if($product->quantity > 0)
                            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800/40">
                                <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                                <span class="text-sm font-bold text-emerald-600 dark:text-emerald-400">In Stock</span>
                            </div>
                        @else
                            <div class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-red-50 dark:bg-red-950/30 border border-red-200 dark:border-red-800/40">
                                <span class="w-2.5 h-2.5 rounded-full bg-red-500"></span>
                                <span class="text-sm font-bold text-red-600 dark:text-red-400">Out of Stock</span>
                            </div>
                        @endif
                    </div>

                    <!-- Product Details -->
                    <div class="bg-slate-50 dark:bg-slate-800/30 rounded-2xl p-4 sm:p-5 border border-slate-100 dark:border-slate-800">
                        <h4 class="text-xs font-extrabold uppercase tracking-widest text-slate-400 mb-4">
                            <i class="fas fa-info-circle text-orange-500 mr-2"></i>Product Details
                        </h4>
                        <div class="space-y-0">
                            <div class="flex justify-between py-3 border-b border-dashed border-slate-200 dark:border-slate-700">
                                <span class="text-slate-400 font-bold text-sm">Product Code</span>
                                <span class="font-extrabold text-orange-500 text-sm">{{ $product->code }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-dashed border-slate-200 dark:border-slate-700">
                                <span class="text-slate-400 font-bold text-sm">Category</span>
                                <span class="font-extrabold text-sm">{{ $product->category->name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between py-3 border-b border-dashed border-slate-200 dark:border-slate-700">
                                <span class="text-slate-400 font-bold text-sm">Product Type</span>
                                <span class="font-extrabold text-sm">{{ $product->type }}</span>
                            </div>
                            <div class="flex justify-between py-3">
                                <span class="text-slate-400 font-bold text-sm">Barcode Format</span>
                                <span class="font-extrabold text-sm">{{ $product->barcode_symbology }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Barcode Display -->
                    <div class="text-center">
                        <div class="inline-block bg-white p-4 sm:p-6 rounded-2xl border border-slate-100 dark:border-slate-800 shadow-sm max-w-full overflow-x-auto">
                            <svg id="publicBarcode" class="max-w-full h-auto"></svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm">
                    <div class="w-6 h-6 bg-gradient-to-tr from-orange-600 to-orange-400 rounded-lg flex items-center justify-center">
                        <span class="text-white font-extrabold text-[8px]">MZ</span>
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        MZ Inventory Pro &bull; Product Details
                    </p>
                </div>
            </div>

        @else
            <!-- Product Not Found -->
            <div class="premium-card overflow-hidden animate-slide-up">
                <div class="bg-gradient-to-r from-red-500 to-red-400 p-5 sm:p-6 text-white flex items-center gap-3 sm:gap-4">
                    <div class="w-12 h-12 sm:w-14 sm:h-14 bg-white/20 backdrop-blur-sm rounded-2xl flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-exclamation-triangle text-xl sm:text-2xl"></i>
                    </div>
                    <div>
                        <h1 class="text-lg sm:text-2xl font-extrabold tracking-tight">Product Not Found</h1>
                        <p class="text-white/80 text-xs sm:text-sm font-medium mt-0.5">Code: <span class="font-bold text-white">{{ $code }}</span></p>
                    </div>
                </div>
                <div class="p-10 sm:p-16 text-center">
                    <i class="fas fa-box-open text-6xl sm:text-7xl text-slate-200 dark:text-slate-700 mb-6 block"></i>
                    <p class="text-lg font-bold text-slate-600 dark:text-slate-300 mb-2">Oops!</p>
                    <p class="text-slate-400 text-sm max-w-xs mx-auto">No product was found matching this code. The product may have been removed or the code is incorrect.</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-8 text-center">
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 shadow-sm">
                    <div class="w-6 h-6 bg-gradient-to-tr from-orange-600 to-orange-400 rounded-lg flex items-center justify-center">
                        <span class="text-white font-extrabold text-[8px]">MZ</span>
                    </div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                        MZ Inventory Pro
                    </p>
                </div>
            </div>
        @endif
    </div>

    <script>
        // Theme Toggle
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

        @if($product)
        // Generate barcode
        document.addEventListener('DOMContentLoaded', function() {
            let format = '{{ $product->barcode_symbology }}' || 'CODE128';
            if (format === 'C128') format = 'CODE128';
            if (format === 'C39') format = 'CODE39';

            try {
                JsBarcode("#publicBarcode", "{{ $product->code }}", {
                    format: format,
                    width: 2,
                    height: 60,
                    displayValue: true,
                    fontSize: 13,
                    font: "Outfit",
                    margin: 10
                });
            } catch(e) {
                try {
                    JsBarcode("#publicBarcode", "{{ $product->code }}", {
                        format: "CODE128",
                        width: 2,
                        height: 60,
                        displayValue: true,
                        fontSize: 13,
                        font: "Outfit",
                        margin: 10
                    });
                } catch(e2) {
                    console.error("Barcode generation error:", e2);
                }
            }
        });
        @endif
    </script>
</body>

</html>

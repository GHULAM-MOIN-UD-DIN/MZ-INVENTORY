@extends('Layout.index')

@section('title', 'Add New Product')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-orange-500">
                Add New Product
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Fill in the details below to add a new item to your inventory.</p>
        </div>
        <a href="{{ route('product.index') }}" 
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
        
        <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data" 
              class="p-8 space-y-8" id="productForm">
            @csrf

            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 
                                flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-info-circle text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Basic Information</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Enter the core product details</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">
                            Product Name 
                            <span class="text-orange-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="name" 
                                   class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                          bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                          focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                          focus:ring-4 focus:ring-orange-500/10 transition-all duration-300
                                          placeholder:text-slate-400 dark:placeholder:text-slate-500" 
                                   placeholder="e.g. iPhone 15 Pro Max" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">
                            Product Code / SKU 
                            <span class="text-orange-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-barcode text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                            </div>
                            <input type="text" name="code" 
                                   class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                          bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                          focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                          focus:ring-4 focus:ring-orange-500/10 transition-all duration-300
                                          placeholder:text-slate-400 dark:placeholder:text-slate-500" 
                                   placeholder="e.g. APP-IP15PM-256" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">
                            Product Type 
                            <span class="text-orange-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="type" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                           bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                           focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                           focus:ring-4 focus:ring-orange-500/10 transition-all duration-300
                                           appearance-none cursor-pointer" required>
                                @foreach($productTypes as $type)
                                    <option value="{{ $type->name }}" class="bg-white dark:bg-slate-800">
                                        📦 {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">
                            Category 
                            <span class="text-orange-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="category_id" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                           bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                           focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                           focus:ring-4 focus:ring-orange-500/10 transition-all duration-300
                                           appearance-none cursor-pointer" required>
                                <option value="" disabled selected class="bg-white dark:bg-slate-800">
                                    Select Category
                                </option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" class="bg-white dark:bg-slate-800">
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group group">
                        <label class="form-label flex items-center gap-1">
                            Barcode Symbology 
                            <span class="text-orange-500">*</span>
                        </label>
                        <div class="relative">
                            <select name="barcode_symbology" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                           bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                           focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                           focus:ring-4 focus:ring-orange-500/10 transition-all duration-300
                                           appearance-none cursor-pointer" required>
                                @foreach($barcodeSymbologies as $symbology)
                                    <option value="{{ $symbology->name }}" class="bg-white dark:bg-slate-800">{{ $symbology->name }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-barcode text-slate-400 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pricing & Stock Section -->
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 
                                flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-indian-rupee-sign text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Pricing & Stock</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Set your pricing and inventory</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="form-group group">
                        <label class="form-label">Cost Price <span class="text-orange-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-[10px] text-slate-400 group-focus-within:text-orange-500 transition-colors font-black">Rs.</span>
                            </div>
                            <input type="number" step="0.01" name="cost" 
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                          bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                          focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                          focus:ring-4 focus:ring-orange-500/10 transition-all duration-300" 
                                   placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label">Selling Price <span class="text-orange-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-[10px] text-slate-400 group-focus-within:text-orange-500 transition-colors font-black">Rs.</span>
                            </div>
                            <input type="number" step="0.01" name="price" 
                                   class="w-full pl-10 pr-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                          bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                          focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                          focus:ring-4 focus:ring-orange-500/10 transition-all duration-300" 
                                   placeholder="0.00" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label">Quantity <span class="text-orange-500">*</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-boxes-stacked text-slate-400 group-focus-within:text-orange-500 transition-colors"></i>
                            </div>
                            <input type="number" name="quantity" 
                                   class="w-full pl-12 pr-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                          bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                          focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                          focus:ring-4 focus:ring-orange-500/10 transition-all duration-300" 
                                   placeholder="0" required>
                        </div>
                    </div>

                    <div class="form-group group">
                        <label class="form-label">Tax Method <span class="text-orange-500">*</span></label>
                        <div class="relative">
                            <select name="tax_method" 
                                    class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                           bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                           focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                           focus:ring-4 focus:ring-orange-500/10 transition-all duration-300
                                           appearance-none cursor-pointer" required>
                                @foreach($taxMethods as $method)
                                    <option value="{{ $method }}" class="bg-white dark:bg-slate-800">{{ $method }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <i class="fas fa-percent text-slate-400 text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Media & Description Section -->
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 
                                flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-image text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Media & Description</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Add visuals and details</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-6">
                    <div class="form-group group">
                        <label class="form-label">Product Description</label>
                        <textarea name="description" rows="5" 
                                  class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                         bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                         focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                         focus:ring-4 focus:ring-orange-500/10 transition-all duration-300
                                         resize-none placeholder:text-slate-400 dark:placeholder:text-slate-500" 
                                  placeholder="Enter detailed product description..."></textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Product Image</label>
                        <div class="relative group cursor-pointer">
                            <input type="file" name="image" id="imageInput" 
                                   class="absolute inset-0 opacity-0 cursor-pointer z-10" accept="image/*">
                            <div id="dropZone" 
                                 class="p-10 border-2 border-dashed border-slate-300 dark:border-slate-700 
                                        rounded-2xl flex flex-col items-center justify-center gap-3 
                                        group-hover:border-orange-500 group-hover:bg-orange-50 dark:group-hover:bg-orange-900/10 
                                        transition-all duration-300">
                                <div id="previewContainer" class="hidden mb-4">
                                    <img id="imagePreview" class="max-h-48 rounded-xl shadow-lg" alt="Preview">
                                </div>
                                <div id="uploadPlaceholder" class="flex flex-col items-center gap-3">
                                    <div class="w-16 h-16 rounded-full bg-gradient-to-br from-orange-100 to-orange-200 
                                                dark:from-orange-900 dark:to-orange-800 flex items-center justify-center 
                                                group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-cloud-arrow-up text-2xl text-orange-500 dark:text-orange-400 
                                                  group-hover:translate-y-[-2px] transition-transform"></i>
                                    </div>
                                    <div class="text-center">
                                        <p class="text-sm font-bold text-slate-700 dark:text-slate-300">
                                            Click or drag image to upload
                                        </p>
                                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                            PNG, JPG or WEBP (Max. 5MB)
                                        </p>
                                    </div>
                                    <div id="fileName" 
                                         class="hidden mt-2 px-4 py-2 bg-gradient-to-r from-orange-500 to-orange-600 
                                                text-white text-xs font-bold rounded-full shadow-lg shadow-orange-500/25">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="flex flex-col sm:flex-row items-center justify-end gap-4 pt-8 
                        border-t-2 border-slate-100 dark:border-slate-800">
                <button type="reset" id="resetBtn"
                        class="w-full sm:w-auto px-8 py-3.5 rounded-xl text-sm font-bold 
                               text-slate-600 dark:text-slate-400 
                               hover:bg-slate-100 dark:hover:bg-slate-800 
                               hover:text-slate-800 dark:hover:text-slate-200
                               border-2 border-transparent hover:border-slate-300 dark:hover:border-slate-700
                               transition-all duration-300">
                    <i class="fas fa-redo mr-2"></i>Reset Form
                </button>
                <button type="submit" 
                        class="w-full sm:w-auto px-10 py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 
                               hover:from-orange-600 hover:to-orange-700 text-white font-bold rounded-xl 
                               shadow-lg shadow-orange-500/25 hover:shadow-xl hover:shadow-orange-500/30 
                               transform hover:-translate-y-0.5 transition-all duration-300">
                    <i class="fas fa-save mr-2"></i>Save Product
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    
    @keyframes slide-up {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    
    .animate-fade-in {
        animation: fade-in 0.6s ease-out;
    }
    
    .animate-slide-up {
        animation: slide-up 0.6s ease-out;
    }
    
    .stagger-1 {
        animation-delay: 0.2s;
    }
    
    /* Custom scrollbar for textareas */
    textarea::-webkit-scrollbar {
        width: 6px;
    }
    
    textarea::-webkit-scrollbar-track {
        background: transparent;
    }
    
    textarea::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 3px;
    }
    
    textarea::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
</style>

<script>
    // Enhanced Image Upload with Preview
    const imageInput = document.getElementById('imageInput');
    const dropZone = document.getElementById('dropZone');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const fileName = document.getElementById('fileName');

    // Handle file selection
    imageInput.addEventListener('change', handleFileSelect);
    
    // Drag and drop functionality
    dropZone.addEventListener('dragover', (e) => {
        e.preventDefault();
        dropZone.classList.add('border-orange-500', 'bg-orange-50', 'dark:bg-orange-900/10');
    });
    
    dropZone.addEventListener('dragleave', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-orange-500', 'bg-orange-50', 'dark:bg-orange-900/10');
    });
    
    dropZone.addEventListener('drop', (e) => {
        e.preventDefault();
        dropZone.classList.remove('border-orange-500', 'bg-orange-50', 'dark:bg-orange-900/10');
        
        const files = e.dataTransfer.files;
        if (files.length > 0) {
            imageInput.files = files;
            handleFileSelect();
        }
    });

    function handleFileSelect() {
        const file = imageInput.files[0];
        if (file) {
            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type',
                    text: 'Please select a valid image file (PNG, JPG, or WEBP)',
                    confirmButtonColor: '#f97316'
                });
                imageInput.value = '';
                return;
            }
            
            // Validate file size (5MB)
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large',
                    text: 'File size must be less than 5MB',
                    confirmButtonColor: '#f97316'
                });
                imageInput.value = '';
                return;
            }
            
            // Show file name
            fileName.textContent = '📎 ' + file.name;
            fileName.classList.remove('hidden');
            
            // Show image preview
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                previewContainer.classList.remove('hidden');
                uploadPlaceholder.classList.add('hidden');
            };
            reader.readAsDataURL(file);
        } else {
            resetUpload();
        }
    }
    
    function resetUpload() {
        previewContainer.classList.add('hidden');
        uploadPlaceholder.classList.remove('hidden');
        fileName.classList.add('hidden');
        imagePreview.src = '';
    }

    // Reset button functionality
    document.getElementById('resetBtn').addEventListener('click', resetUpload);

    // Form submission with loading state
    document.getElementById('productForm').addEventListener('submit', function(e) {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i>Saving...';
        btn.classList.add('opacity-75', 'cursor-not-allowed');
    });
    
    // Add smooth hover effects for all inputs
    document.querySelectorAll('input, select, textarea').forEach(element => {
        element.addEventListener('focus', function() {
            this.closest('.form-group')?.classList.add('scale-[1.02]');
        });
        
        element.addEventListener('blur', function() {
            this.closest('.form-group')?.classList.remove('scale-[1.02]');
        });
    });
</script>
@endsection
@extends('Layout.index')

@section('title', 'Add New Category')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-orange-500">
                Add New Category
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Create a new category to organize and group your inventory items.</p>
        </div>
        <a href="{{ route('category.index') }}" 
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
        
        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data" 
              class="p-8 space-y-8" id="categoryForm">
            @csrf

            <!-- Basic Information Section -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 
                                flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-tag text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Category Details</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Define the category name and properties</p>
                    </div>
                </div>

                <div class="form-group group">
                    <label class="form-label flex items-center gap-1">
                        Category Name 
                        <span class="text-orange-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="name" 
                               class="w-full px-4 py-3 rounded-xl border-2 border-slate-200 dark:border-slate-700 
                                      bg-slate-50 dark:bg-slate-800 text-slate-800 dark:text-slate-200
                                      focus:border-orange-500 focus:bg-white dark:focus:bg-slate-900 
                                      focus:ring-4 focus:ring-orange-500/10 transition-all duration-300
                                      placeholder:text-slate-400 dark:placeholder:text-slate-500" 
                               placeholder="e.g. Electronics, Smartphones, Furniture" required>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-orange-400 to-orange-600 
                                flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-image text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Category Visual</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Add an icon or image for this category</p>
                    </div>
                </div>

                <div class="form-group">
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
                                        Click or drag icon to upload
                                    </p>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                                        PNG, JPG or WEBP (Max. 2MB)
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
                    <i class="fas fa-save mr-2"></i>Save Category
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Enhanced Image Upload with Preview
    const imageInput = document.getElementById('imageInput');
    const dropZone = document.getElementById('dropZone');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const fileName = document.getElementById('fileName');

    imageInput.addEventListener('change', handleFileSelect);
    
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
            fileName.textContent = '📎 ' + file.name;
            fileName.classList.remove('hidden');
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

    document.getElementById('resetBtn').addEventListener('click', resetUpload);

    document.getElementById('categoryForm').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i>Saving...';
    });
</script>
@endsection

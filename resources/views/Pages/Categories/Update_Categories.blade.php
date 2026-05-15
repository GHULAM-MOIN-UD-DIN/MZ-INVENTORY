@extends('Layout.index')

@section('title', 'Update Category')

@section('content')
<div class="max-w-4xl mx-auto space-y-8 animate-fade-in">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-3xl font-extrabold tracking-tight text-orange-500">
                Update Category
            </h2>
            <p class="text-slate-500 dark:text-slate-400 mt-1">Refine and update the details of your inventory category.</p>
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
        
        <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data" 
              class="p-8 space-y-8" id="categoryForm">
            @csrf

            <!-- Basic Info -->
            <div class="space-y-6">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-pen-to-square text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Category Identity</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Modify the category name</p>
                    </div>
                </div>

                <div class="form-group group">
                    <label class="form-label flex items-center gap-1">Category Name <span class="text-orange-500">*</span></label>
                    <div class="relative">
                        <input type="text" name="name" class="form-input" value="{{ $category->name }}" required>
                    </div>
                </div>
            </div>

            <!-- Media Section -->
            <div class="space-y-6 pt-4">
                <div class="flex items-center gap-3 pb-4 border-b-2 border-slate-100 dark:border-slate-800">
                    <div class="w-12 h-12 rounded-xl bg-orange-500 flex items-center justify-center text-white shadow-lg shadow-orange-500/25">
                        <i class="fas fa-image text-lg"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-slate-800 dark:text-slate-200">Category Visual</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Update the category icon or image</p>
                    </div>
                </div>

                <div class="flex flex-col md:flex-row items-start gap-8">
                    @if($category->image)
                        <div class="w-40 h-40 rounded-2xl overflow-hidden border-2 border-orange-500/20 shadow-xl shrink-0 group relative">
                            <img src="{{ $category->image ? cloudinary_url($category->image) : asset('assets/images/no-image.png') }}" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center">
                                <span class="text-white text-[10px] font-bold uppercase tracking-widest">Current Image</span>
                            </div>
                        </div>
                    @endif
                    
                    <div class="relative group cursor-pointer flex-1 w-full">
                        <input type="file" name="image" id="imageInput" 
                               class="absolute inset-0 opacity-0 cursor-pointer z-10" accept="image/*">
                        <div id="dropZone" 
                             class="p-10 border-2 border-dashed border-slate-300 dark:border-slate-700 rounded-2xl flex flex-col items-center justify-center gap-3 group-hover:border-orange-500 group-hover:bg-orange-500/5 transition-all">
                            <div id="previewContainer" class="hidden mb-4">
                                <img id="imagePreview" class="max-h-48 rounded-xl shadow-lg" alt="Preview">
                            </div>
                            <div id="uploadPlaceholder" class="flex flex-col items-center gap-3 text-center">
                                <div class="w-12 h-12 rounded-full bg-orange-100 dark:bg-orange-900/20 flex items-center justify-center text-orange-500">
                                    <i class="fas fa-cloud-arrow-up text-xl"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-600 dark:text-slate-300">Choose new image to replace</p>
                                <p class="text-xs text-slate-400">PNG, JPG or WEBP (Max. 2MB)</p>
                                <div id="fileName" class="hidden mt-2 px-4 py-2 bg-orange-500 text-white text-xs font-bold rounded-full shadow-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="pt-8 border-t-2 border-slate-100 dark:border-slate-800 flex justify-end gap-4">
                <a href="{{ route('category.index') }}" class="px-8 py-3.5 rounded-xl text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all">
                    Cancel Changes
                </a>
                <button type="submit" class="px-10 py-3.5 bg-orange-500 hover:bg-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-500/25 hover:shadow-xl transition-all transform hover:-translate-y-0.5">
                    <i class="fas fa-save mr-2"></i>
                    Update Category
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const dropZone = document.getElementById('dropZone');
    const previewContainer = document.getElementById('previewContainer');
    const imagePreview = document.getElementById('imagePreview');
    const uploadPlaceholder = document.getElementById('uploadPlaceholder');
    const fileName = document.getElementById('fileName');

    imageInput.addEventListener('change', handleFileSelect);
    
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
        }
    }

    document.getElementById('categoryForm').addEventListener('submit', function() {
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-circle-notch fa-spin mr-2"></i>Updating...';
    });
</script>
@endsection

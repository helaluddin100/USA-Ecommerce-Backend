@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')
    <div class="-mx-2 sm:-mx-4">
        <div class="mb-6 px-2 sm:px-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-100">Create New Product</h1>
            <p class="text-sm text-gray-400 mt-1">Add a new product to your catalog.</p>
        </div>

        <div class="bg-gray-950/95 border border-gray-800 rounded-2xl shadow-2xl shadow-black/40 px-3 sm:px-6 py-5 sm:py-6">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" id="product-form">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                    <div class="md:col-span-1">
                        <label for="category_id" class="block text-xs font-semibold text-gray-300 mb-1.5">Category <span class="text-red-500">*</span></label>
                        <select id="category_id" name="category_id" required
                                class="js-select2 w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">Select category</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(old('category_id') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-1">
                        <label for="name" class="block text-xs font-semibold text-gray-300 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Enter product name" required
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('name')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div class="md:col-span-1">
                        <label for="slug" class="block text-xs font-semibold text-gray-300 mb-1.5">Slug <span class="text-gray-500 font-normal">(auto from name)</span></label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="Auto-generated from product name"
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('slug')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                    <div>
                        <label for="price" class="block text-xs font-semibold text-gray-300 mb-1.5">Price <span class="text-red-500">*</span></label>
                        <input type="number" id="price" name="price" step="0.01" min="0" value="{{ old('price', 0) }}" required
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('price')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="old_price" class="block text-xs font-semibold text-gray-300 mb-1.5">Old Price (optional)</label>
                        <input type="number" id="old_price" name="old_price" step="0.01" min="0" value="{{ old('old_price') }}"
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('old_price')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="stock" class="block text-xs font-semibold text-gray-300 mb-1.5">Stock</label>
                        <input type="number" id="stock" name="stock" min="0" value="{{ old('stock', 0) }}"
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('stock')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Product Image Upload + Preview --}}
                <div class="mt-5">
                    <label class="block text-xs font-semibold text-gray-300 mb-1.5">Product Image</label>
                    <input type="hidden" name="image" id="image_fallback" value="{{ old('image') }}" placeholder="Or use file upload below">
                    <div class="flex flex-col sm:flex-row gap-4 items-start">
                        <div class="w-full sm:w-auto flex-shrink-0">
                            <div id="image-preview" class="w-40 h-40 rounded-xl border-2 border-dashed border-gray-600 bg-gray-900/50 flex items-center justify-center overflow-hidden">
                                <span id="image-preview-placeholder" class="text-gray-500 text-sm">No image</span>
                                <img id="image-preview-img" src="" alt="" class="hidden w-full h-full object-cover">
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <label for="image_file" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg bg-emerald-600 text-sm font-semibold text-white hover:bg-emerald-500 cursor-pointer transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Choose Image
                            </label>
                            <input type="file" id="image_file" name="image_file" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" class="sr-only">
                            <p class="mt-2 text-xs text-gray-500">PNG, JPG, GIF, WebP. Max 2MB. Saved as WebP.</p>
                            @error('image_file')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label for="badge" class="block text-xs font-semibold text-gray-300 mb-1.5">Badge</label>
                        <select id="badge" name="badge" class="js-select2 w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 px-3 py-2">
                            <option value="">No badge</option>
                            <option value="New" @selected(old('badge') === 'New')>New</option>
                            <option value="Best Seller" @selected(old('badge') === 'Best Seller')>Best Seller</option>
                            <option value="Deal" @selected(old('badge') === 'Deal')>Deal</option>
                        </select>
                        @error('badge')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Description - Rich Text Editor --}}
                <div class="mt-5">
                    <label for="description" class="block text-xs font-semibold text-gray-300 mb-1.5">Description</label>
                    <textarea name="description" id="description" class="hidden">{{ old('description') }}</textarea>
                    <div id="description-editor" class="rounded-lg border border-gray-700 bg-gray-900 min-h-[200px] text-gray-100"></div>
                    @error('description')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                {{-- Checkboxes - styled --}}
                <div class="mt-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-6">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-semibold text-gray-300">Status</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <div class="w-11 h-6 bg-gray-700 rounded-full peer peer-checked:bg-emerald-500 transition-colors"></div>
                                <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full shadow transform peer-checked:translate-x-5 transition-transform"></div>
                                <span class="ml-3 text-sm text-gray-400 peer-checked:text-emerald-300">Active</span>
                            </label>
                        </div>
                        <label class="relative flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="is_new" value="1" class="sr-only peer" {{ old('is_new') ? 'checked' : '' }}>
                            <span class="relative flex-shrink-0 w-5 h-5 rounded border-2 border-gray-500 bg-gray-800 group-hover:border-emerald-500 transition peer-checked:border-emerald-500 peer-checked:bg-emerald-500"></span>
                            <svg class="absolute left-1 w-3 h-3 text-white opacity-0 peer-checked:opacity-100 pointer-events-none top-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-sm text-gray-400 group-hover:text-gray-300">New Arrival</span>
                        </label>
                        <label class="relative flex items-center gap-3 cursor-pointer group">
                            <input type="checkbox" name="on_sale" value="1" class="sr-only peer" {{ old('on_sale') ? 'checked' : '' }}>
                            <span class="relative flex-shrink-0 w-5 h-5 rounded border-2 border-gray-500 bg-gray-800 group-hover:border-emerald-500 transition peer-checked:border-emerald-500 peer-checked:bg-emerald-500"></span>
                            <svg class="absolute left-1 w-3 h-3 text-white opacity-0 peer-checked:opacity-100 pointer-events-none top-1/2 -translate-y-1/2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                            <span class="text-sm text-gray-400 group-hover:text-gray-300">On Sale</span>
                        </label>
                    </div>
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.products.index') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-xs sm:text-sm text-gray-200 hover:bg-gray-800">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 text-xs sm:text-sm font-semibold text-white hover:bg-blue-500 shadow-lg shadow-blue-500/30">Create Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">
    <style>
        #description-editor .ql-toolbar.ql-snow { border-color: #374151; background: #111827; }
        #description-editor .ql-container.ql-snow { border-color: #374151; background: #111827; color: #f3f4f6; }
        #description-editor .ql-editor { min-height: 180px; }
    </style>
    <script src="https://cdn.quilljs.com/1.3.7/quill.min.js"></script>
    <script>
        (function() {
            function slugify(text) {
                return String(text).toLowerCase().trim()
                    .replace(/[^\w\s-]/g, '')
                    .replace(/[\s_-]+/g, '-')
                    .replace(/^-+|-+$/g, '');
            }
            var nameEl = document.getElementById('name');
            var slugEl = document.getElementById('slug');
            if (nameEl && slugEl) {
                nameEl.addEventListener('input', function() {
                    if (!slugEl.dataset.manual) slugEl.value = slugify(nameEl.value);
                });
                slugEl.addEventListener('input', function() { slugEl.dataset.manual = '1'; });
                if (nameEl.value && !slugEl.value) slugEl.value = slugify(nameEl.value);
            }

            var descriptionEl = document.getElementById('description');
            var editorEl = document.getElementById('description-editor');
            if (editorEl && descriptionEl) {
                var quill = new Quill(editorEl, {
                    theme: 'snow',
                    placeholder: 'Enter product description...',
                    modules: {
                        toolbar: [
                            [{ 'header': [1, 2, 3, false] }],
                            ['bold', 'italic', 'underline', 'strike'],
                            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
                            ['link'],
                            ['clean']
                        ]
                    }
                });
                quill.root.innerHTML = descriptionEl.value || '';
                document.getElementById('product-form').addEventListener('submit', function() {
                    descriptionEl.value = quill.root.innerHTML;
                });
            }

            var imageInput = document.getElementById('image_file');
            var preview = document.getElementById('image-preview-img');
            var placeholder = document.getElementById('image-preview-placeholder');
            if (imageInput && preview && placeholder) {
                imageInput.addEventListener('change', function() {
                    var file = this.files[0];
                    if (file) {
                        var url = URL.createObjectURL(file);
                        preview.src = url;
                        preview.classList.remove('hidden');
                        placeholder.classList.add('hidden');
                    } else {
                        preview.src = '';
                        preview.classList.add('hidden');
                        placeholder.classList.remove('hidden');
                    }
                });
            }

        })();
    </script>
    @endpush
@endsection

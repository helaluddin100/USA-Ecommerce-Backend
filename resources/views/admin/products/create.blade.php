@extends('layouts.admin')

@section('title', 'Create Product')

@section('content')
    <div class="-mx-2 sm:-mx-4">
        <div class="mb-6 px-2 sm:px-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-100">Create New Product</h1>
            <p class="text-sm text-gray-400 mt-1">Add a new product to your catalog.</p>
        </div>

        <div class="bg-gray-950/95 border border-gray-800 rounded-2xl shadow-2xl shadow-black/40 px-3 sm:px-6 py-5 sm:py-6">
            <form action="{{ route('admin.products.store') }}" method="POST">
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
                        <label for="slug" class="block text-xs font-semibold text-gray-300 mb-1.5">Slug</label>
                        <input type="text" id="slug" name="slug" value="{{ old('slug') }}" placeholder="auto from name"
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

                <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label for="image" class="block text-xs font-semibold text-gray-300 mb-1.5">Image (emoji or URL)</label>
                        <input type="text" id="image" name="image" value="{{ old('image') }}" placeholder="e.g. 🎧 or image URL"
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('image')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
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

                <div class="mt-5">
                    <label for="description" class="block text-xs font-semibold text-gray-300 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="4" placeholder="Enter product description"
                              class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex flex-wrap items-center gap-4">
                        <div class="flex items-center gap-3">
                            <span class="text-xs font-semibold text-gray-300">Status</span>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="hidden" name="is_active" value="0">
                                <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ old('is_active', 1) ? 'checked' : '' }}>
                                <div class="w-10 h-5 bg-gray-700 rounded-full peer peer-checked:bg-emerald-500 transition-colors"></div>
                                <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow transform peer-checked:translate-x-5 transition-transform"></div>
                                <span class="ml-3 text-xs text-gray-400 peer-checked:text-emerald-300">Active</span>
                            </label>
                        </div>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="is_new" value="1" {{ old('is_new') ? 'checked' : '' }}
                                   class="rounded border-gray-600 bg-gray-800 text-emerald-500 focus:ring-emerald-500">
                            <span class="text-xs text-gray-400">New Arrival</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="on_sale" value="1" {{ old('on_sale') ? 'checked' : '' }}
                                   class="rounded border-gray-600 bg-gray-800 text-emerald-500 focus:ring-emerald-500">
                            <span class="text-xs text-gray-400">On Sale</span>
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
@endsection

@extends('layouts.admin')

@section('title', 'Create Category')

@section('content')
    <div class="-mx-2 sm:-mx-4">
        <div class="mb-6 px-2 sm:px-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-100">Create New Category</h1>
            <p class="text-sm text-gray-400 mt-1">
                Add a new category to your system.
            </p>
        </div>

        <div class="bg-gray-950/95 border border-gray-800 rounded-2xl shadow-2xl shadow-black/40 px-3 sm:px-6 py-5 sm:py-6">
            <form action="{{ route('admin.categories.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
                    <div class="md:col-span-1">
                        <label for="name" class="block text-xs font-semibold text-gray-300 mb-1.5">
                            Category Name <span class="text-red-500">*</span>
                        </label>
                        <input
                            type="text"
                            id="name"
                            name="name"
                            value="{{ old('name') }}"
                            placeholder="Enter category name"
                            class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500"
                            required
                        >
                        @error('name')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label for="slug" class="block text-xs font-semibold text-gray-300 mb-1.5">
                            Category Code
                        </label>
                        <input
                            type="text"
                            id="slug"
                            name="slug"
                            value="{{ old('slug') }}"
                            placeholder="CATEGORY-CODE"
                            class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                        <p class="mt-1 text-[11px] text-gray-500">
                            Only lowercase letters, numbers, and hyphens (-) are allowed. Empty = auto from name.
                        </p>
                        @error('slug')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="md:col-span-1">
                        <label for="sort_order" class="block text-xs font-semibold text-gray-300 mb-1.5">
                            Display Order
                        </label>
                        <input
                            type="number"
                            id="sort_order"
                            name="sort_order"
                            min="0"
                            max="9999"
                            value="{{ old('sort_order', 0) }}"
                            class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                        <p class="mt-1 text-[11px] text-gray-500">
                            Lower value appears first.
                        </p>
                        @error('sort_order')
                        <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="mt-5">
                    <label class="block text-xs font-semibold text-gray-300 mb-1.5">
                        Description
                    </label>
                    <textarea
                        rows="4"
                        placeholder="Enter category description"
                        class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500"
                        readonly
                    ></textarea>
                </div>

                <div class="mt-5">
                    <label class="block text-xs font-semibold text-gray-300 mb-1.5">
                        Category Image
                    </label>
                    <div class="border border-dashed border-gray-700 rounded-xl bg-gray-900/60 px-4 py-6 flex flex-col items-center justify-center text-center">
                        <div class="w-10 h-10 rounded-full border border-gray-700 flex items-center justify-center mb-3">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-9h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <p class="text-sm text-gray-300">
                            Upload a file or drag and drop
                        </p>
                        <p class="text-xs text-gray-500 mt-1">
                            PNG, JPG, GIF, SVG up to 2MB
                        </p>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-3">
                        <span class="text-xs font-semibold text-gray-300">Status</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            @php
                                $status = old('is_active', 1);
                            @endphp
                            <input type="hidden" name="is_active" value="0">
                            <input type="checkbox" name="is_active" value="1" class="sr-only peer" {{ $status ? 'checked' : '' }}>
                            <div class="w-10 h-5 bg-gray-700 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-emerald-500 rounded-full peer peer-checked:bg-emerald-500 transition-colors">
                            </div>
                            <div class="absolute left-0.5 top-0.5 w-4 h-4 bg-white rounded-full shadow transform peer-checked:translate-x-5 transition-transform"></div>
                            <span class="ml-3 text-xs text-gray-400 peer-checked:text-emerald-300">Active</span>
                        </label>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.categories.index') }}"
                           class="px-4 py-2 rounded-lg border border-gray-600 text-xs sm:text-sm text-gray-200 hover:bg-gray-800">
                            Cancel
                        </a>
                        <button type="submit"
                                class="px-5 py-2.5 rounded-lg bg-blue-600 text-xs sm:text-sm font-semibold text-white hover:bg-blue-500 shadow-lg shadow-blue-500/30">
                            Create Category
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection


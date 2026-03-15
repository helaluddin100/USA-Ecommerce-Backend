@extends('layouts.admin')

@section('title', 'Create Slider')

@section('content')
    <div class="-mx-2 sm:-mx-4">
        <div class="mb-6 px-2 sm:px-4">
            <h1 class="text-xl sm:text-2xl font-semibold text-gray-100">Create New Slider</h1>
            <p class="text-sm text-gray-400 mt-1">Add a new slider with image upload.</p>
        </div>

        <div class="bg-gray-950/95 border border-gray-800 rounded-2xl shadow-2xl shadow-black/40 px-3 sm:px-6 py-5 sm:py-6">
            <form action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label for="title" class="block text-xs font-semibold text-gray-300 mb-1.5">Title <span class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" placeholder="Slider title" required
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('title')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="subtitle" class="block text-xs font-semibold text-gray-300 mb-1.5">Subtitle</label>
                        <input type="text" id="subtitle" name="subtitle" value="{{ old('subtitle') }}" placeholder="Optional subtitle"
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('subtitle')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-5">
                    <label for="description" class="block text-xs font-semibold text-gray-300 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="3" placeholder="Optional description"
                              class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('description') }}</textarea>
                    @error('description')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label for="link" class="block text-xs font-semibold text-gray-300 mb-1.5">Link URL</label>
                        <input type="text" id="link" name="link" value="{{ old('link') }}" placeholder="https://..."
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('link')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="link_text" class="block text-xs font-semibold text-gray-300 mb-1.5">Link Button Text</label>
                        <input type="text" id="link_text" name="link_text" value="{{ old('link_text') }}" placeholder="Shop Now"
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('link_text')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-5">
                    <label for="image" class="block text-xs font-semibold text-gray-300 mb-1.5">Slider Image <span class="text-red-500">*</span></label>
                    <div class="mt-2 flex justify-center rounded-xl border-2 border-dashed border-gray-600 bg-gray-900/50 px-6 py-10 hover:border-gray-500 transition-colors">
                        <div class="text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-500" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="mt-4 flex flex-col sm:flex-row gap-2 justify-center">
                                <label for="image" class="relative cursor-pointer rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500">
                                    <span>Choose Image</span>
                                    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/jpg,image/gif,image/webp" required
                                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                                </label>
                                <span class="text-xs text-gray-400 self-center">PNG, JPG, GIF, WebP up to 2MB</span>
                            </div>
                            <p id="file-name" class="mt-2 text-xs text-emerald-400"></p>
                        </div>
                    </div>
                    @error('image')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                </div>

                <div class="mt-5 grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-6">
                    <div>
                        <label for="bg_class" class="block text-xs font-semibold text-gray-300 mb-1.5">Background Class (optional)</label>
                        <input type="text" id="bg_class" name="bg_class" value="{{ old('bg_class') }}" placeholder="e.g. bg-gradient-to-r from-blue-600 to-purple-600"
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 placeholder:text-gray-500 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('bg_class')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="sort_order" class="block text-xs font-semibold text-gray-300 mb-1.5">Sort Order</label>
                        <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', 0) }}"
                               class="w-full rounded-lg border border-gray-700 bg-gray-900 text-sm text-gray-100 px-3 py-2 focus:ring-emerald-500 focus:border-emerald-500">
                        @error('sort_order')<p class="mt-1 text-xs text-red-400">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
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
                    <div class="flex items-center gap-2">
                        <a href="{{ route('admin.sliders.index') }}" class="px-4 py-2 rounded-lg border border-gray-600 text-xs sm:text-sm text-gray-200 hover:bg-gray-800">Cancel</a>
                        <button type="submit" class="px-5 py-2.5 rounded-lg bg-blue-600 text-xs sm:text-sm font-semibold text-white hover:bg-blue-500 shadow-lg shadow-blue-500/30">Create Slider</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.getElementById('image').addEventListener('change', function() {
            const fileName = this.files[0] ? this.files[0].name : '';
            document.getElementById('file-name').textContent = fileName ? 'Selected: ' + fileName : '';
        });
    </script>
    @endpush
@endsection

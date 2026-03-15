@php
    /** @var \App\Models\Category|null $category */
    $isEdit = isset($category);
@endphp

@csrf

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div>
        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            Name <span class="text-red-500">*</span>
        </label>
        <input type="text" id="name" name="name"
               value="{{ old('name', $category->name ?? '') }}"
               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-emerald-500 focus:border-emerald-500"
               required>
        @error('name')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="slug" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            Slug
        </label>
        <input type="text" id="slug" name="slug"
               value="{{ old('slug', $category->slug ?? '') }}"
               placeholder="auto-generated from name if empty"
               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-emerald-500 focus:border-emerald-500">
        @error('slug')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="color" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            Tailwind Color Class
        </label>
        <select id="color" name="color"
                class="js-select2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100"
        >
            <option value="">No badge</option>
            @php
                $options = [
                    'bg-blue-100 text-blue-700' => 'Blue',
                    'bg-pink-100 text-pink-700' => 'Pink',
                    'bg-green-100 text-green-700' => 'Green',
                    'bg-amber-100 text-amber-700' => 'Amber',
                    'bg-purple-100 text-purple-700' => 'Purple',
                    'bg-rose-100 text-rose-700' => 'Rose',
                ];
                $selectedColor = old('color', $category->color ?? '');
            @endphp
            @foreach($options as $value => $label)
                <option value="{{ $value }}" @selected($selectedColor === $value)>{{ $label }}</option>
            @endforeach
        </select>
        @error('color')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="sort_order" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            Sort Order
        </label>
        <input type="number" id="sort_order" name="sort_order" min="0" max="9999"
               value="{{ old('sort_order', $category->sort_order ?? 0) }}"
               class="block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100 focus:ring-emerald-500 focus:border-emerald-500">
        @error('sort_order')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="is_active" class="block text-sm font-medium text-gray-700 dark:text-gray-200 mb-1">
            Status
        </label>
        <select id="is_active" name="is_active"
                class="js-select2 block w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-100">
            @php
                $status = old('is_active', isset($category) ? (int) $category->is_active : 1);
            @endphp
            <option value="1" @selected($status === 1)>Active</option>
            <option value="0" @selected($status === 0)>Inactive</option>
        </select>
        @error('is_active')
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex items-center justify-end gap-3">
    <a href="{{ route('admin.categories.index') }}"
       class="px-4 py-2 rounded-lg border border-gray-300 text-sm text-gray-700 hover:bg-gray-50">
        Cancel
    </a>
    <button type="submit"
            class="px-5 py-2.5 rounded-lg bg-emerald-600 text-sm font-semibold text-white hover:bg-emerald-700 shadow">
        {{ $isEdit ? 'Update Category' : 'Create Category' }}
    </button>
</div>


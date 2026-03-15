@extends('layouts.admin')

@section('title', 'Categories')

@section('content')
    <div class="mb-6">
        <div class="bg-gray-900/95 border border-gray-800 rounded-2xl shadow-xl shadow-black/40 px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-lg sm:text-xl font-semibold text-white">Categories Management</h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
                        Manage all your categories and keep your catalog organized.
                    </p>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        type="button"
                        class="hidden sm:inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-amber-500/10 border border-amber-400/40 text-xs font-semibold text-amber-200 hover:bg-amber-500/20"
                    >
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
                        View Deleted Categories
                    </button>
                    <a href="{{ route('admin.categories.create') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-500 text-xs sm:text-sm font-semibold text-white hover:bg-emerald-600 shadow-lg shadow-emerald-500/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 4v16m8-8H4"></path>
                        </svg>
                        Add New Category
                    </a>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.categories.index') }}" class="mt-4 space-y-3">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                    <div class="col-span-1 md:col-span-1">
                        <label class="block text-xs font-medium text-gray-400 mb-1">Search</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center text-gray-500 text-xs">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"></path>
                                </svg>
                            </span>
                            <input
                                type="text"
                                name="search"
                                value="{{ request('search') }}"
                                placeholder="Search by name or slug..."
                                class="w-full pl-9 pr-3 py-2 text-xs sm:text-sm rounded-lg border border-gray-700 bg-gray-900 text-gray-100 placeholder:text-gray-500 focus:ring-emerald-500 focus:border-emerald-500"
                            >
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">Status</label>
                        <select
                            name="status"
                            class="js-select2 w-full text-xs sm:text-sm rounded-lg border border-gray-700 bg-gray-900 text-gray-100"
                        >
                            <option value="">All Status</option>
                            <option value="active" @selected(request('status') === 'active')>Active</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-400 mb-1">Sort By</label>
                        <select
                            name="sort"
                            class="js-select2 w-full text-xs sm:text-sm rounded-lg border border-gray-700 bg-gray-900 text-gray-100"
                        >
                            <option value="display_order" @selected(request('sort', 'display_order') === 'display_order')>
                                Display Order
                            </option>
                            <option value="name" @selected(request('sort') === 'name')>
                                Name
                            </option>
                            <option value="created_at" @selected(request('sort') === 'created_at')>
                                Created At
                            </option>
                        </select>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-2 pt-2">
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-blue-600 text-xs sm:text-sm font-semibold text-white hover:bg-blue-500">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v3H3V4zm0 5h18v11a1 1 0 01-1 1H4a1 1 0 01-1-1V9z"></path>
                        </svg>
                        Apply Filters
                    </button>
                    @if(request()->hasAny(['search', 'status', 'sort']))
                        <a href="{{ route('admin.categories.index') }}"
                           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg border border-gray-600 text-xs sm:text-sm text-gray-200 hover:bg-gray-800">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-emerald-50 text-emerald-800 text-sm border border-emerald-100">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-950/90 dark:bg-gray-900 rounded-2xl shadow-2xl shadow-black/40 border border-gray-800 overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-900/80">
            <tr>
                <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">ID</th>
                <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Category Name</th>
                <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Category Code</th>
                <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Display Order</th>
                <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Created At</th>
                <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                <th class="px-4 py-3 text-right text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Actions</th>
            </tr>
            </thead>
            <tbody class="bg-gray-950/90 divide-y divide-gray-800">
            @forelse ($categories as $category)
                <tr class="hover:bg-gray-900/80 transition-colors">
                    <td class="px-4 py-3 text-xs text-gray-400">
                        {{ $category->id }}
                    </td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-100">
                        {{ $category->name }}
                    </td>
                    <td class="px-4 py-3 text-[11px]">
                        {{ $category->slug }}
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-300">
                        {{ $category->sort_order ?? '—' }}
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-400">
                        {{ optional($category->created_at)->format('M d, Y') }}
                    </td>
                    <td class="px-4 py-3 text-sm">
                        @if ($category->is_active)
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-300 border border-emerald-500/40">
                                Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-gray-700 text-gray-200 border border-gray-600">
                                Inactive
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-right">
                        <div class="inline-flex items-center gap-2">
                            <a href="{{ route('admin.categories.edit', $category) }}"
                               class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500/10 border border-blue-400/60 text-blue-300 hover:bg-blue-500/20"
                               title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15.232 5.232l3.536 3.536M4 20h4l9.5-9.5a1.5 1.5 0 00-2.121-2.121L6 17.879 4 20z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-500/10 border border-red-400/60 text-red-300 hover:bg-red-500/20"
                                        title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v2H9V4a1 1 0 011-1z"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-400">
                        No categories found. Create your first category.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        @if ($categories->hasPages())
            <div class="px-4 py-3 border-t border-gray-800 bg-gray-950/90 flex items-center justify-between text-xs text-gray-400">
                <div>
                    Showing
                    <span class="font-semibold text-gray-200">{{ $categories->firstItem() }}</span>
                    to
                    <span class="font-semibold text-gray-200">{{ $categories->lastItem() }}</span>
                    of
                    <span class="font-semibold text-gray-200">{{ $categories->total() }}</span>
                    categories
                </div>
                <div class="text-right">
                    {{ $categories->onEachSide(1)->links() }}
                </div>
            </div>
        @endif
    </div>
@endsection


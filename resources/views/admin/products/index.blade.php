@extends('layouts.admin')

@section('title', 'Products')

@section('content')
    <div class="mb-6">
        <div class="bg-gray-900/95 border border-gray-800 rounded-2xl shadow-xl shadow-black/40 px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-lg sm:text-xl font-semibold text-white">Products Management</h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
                        Manage all your products and inventory.
                    </p>
                </div>
                <a href="{{ route('admin.products.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-500 text-xs sm:text-sm font-semibold text-white hover:bg-emerald-600 shadow-lg shadow-emerald-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Product
                </a>
            </div>

            <form method="GET" action="{{ route('admin.products.index') }}" class="mt-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Search</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"></path>
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Search by name, code, or description..."
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-gray-700 bg-gray-900/80 text-gray-100 placeholder:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Category</label>
                        <select name="category_id" class="w-full text-sm rounded-xl border border-gray-700 bg-gray-900/80 text-gray-100 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" @selected(request('category_id') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Status</label>
                        <select name="status" class="w-full text-sm rounded-xl border border-gray-700 bg-gray-900/80 text-gray-100 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50">
                            <option value="">All Status</option>
                            <option value="active" @selected(request('status') === 'active')>Active</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Sort By</label>
                        <select name="sort" class="w-full text-sm rounded-xl border border-gray-700 bg-gray-900/80 text-gray-100 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50">
                            <option value="created_at" @selected(request('sort', 'created_at') === 'created_at')>Newest First</option>
                            <option value="name" @selected(request('sort') === 'name')>Name A–Z</option>
                            <option value="price_asc" @selected(request('sort') === 'price_asc')>Price: Low to High</option>
                            <option value="price_desc" @selected(request('sort') === 'price_desc')>Price: High to Low</option>
                        </select>
                    </div>
                </div>
                <div class="flex flex-wrap items-center gap-3 mt-4 pt-4 border-t border-gray-800">
                    <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-sm font-semibold text-white hover:bg-blue-500 shadow-lg shadow-blue-500/20 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v3H3V4zm0 5h18v11a1 1 0 01-1 1H4a1 1 0 01-1-1V9z"></path>
                        </svg>
                        Apply Filters
                    </button>
                    @if(request()->hasAny(['search', 'category_id', 'status', 'sort']))
                        <a href="{{ route('admin.products.index') }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-600 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Clear
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-emerald-500/10 text-emerald-300 text-sm border border-emerald-500/30">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-gray-950/90 dark:bg-gray-900 rounded-2xl shadow-2xl shadow-black/40 border border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-gray-900/80">
                <tr>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Image</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Product Name</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Category</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Price</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Stock</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-right text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-gray-950/90 divide-y divide-gray-800">
                @forelse ($products as $product)
                    <tr class="hover:bg-gray-900/80 transition-colors">
                        <td class="px-4 py-3">
                            @if($product->image)
                                <span class="text-2xl">{{ $product->image }}</span>
                            @else
                                <span class="w-10 h-10 rounded-lg bg-gray-800 flex items-center justify-center text-gray-500 text-sm">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-100">{{ $product->name }}</td>
                        <td class="px-4 py-3 text-xs text-gray-400">{{ $product->category->name ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-200">${{ number_format($product->price, 2) }}</td>
                        <td class="px-4 py-3 text-xs text-gray-400">{{ $product->stock }}</td>
                        <td class="px-4 py-3">
                            @if ($product->is_active)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-300 border border-emerald-500/40">Active</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-gray-700 text-gray-200 border border-gray-600">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.products.edit', $product) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500/10 border border-blue-400/60 text-blue-300 hover:bg-blue-500/20" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4l9.5-9.5a1.5 1.5 0 00-2.121-2.121L6 17.879 4 20z"></path></svg>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-red-500/10 border border-red-400/60 text-red-300 hover:bg-red-500/20" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4a1 1 0 011 1v2H9V4a1 1 0 011-1z"></path></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-400">No products found. Create your first product.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($products->hasPages())
            <div class="px-4 py-3 border-t border-gray-800 bg-gray-950/90 flex items-center justify-between text-xs text-gray-400">
                <div>Showing <span class="font-semibold text-gray-200">{{ $products->firstItem() ?? 0 }}</span> to <span class="font-semibold text-gray-200">{{ $products->lastItem() ?? 0 }}</span> of <span class="font-semibold text-gray-200">{{ $products->total() }}</span> products</div>
                <div>{{ $products->onEachSide(1)->links() }}</div>
            </div>
        @endif
    </div>
@endsection

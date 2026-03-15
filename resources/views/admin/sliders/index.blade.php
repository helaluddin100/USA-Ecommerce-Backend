@extends('layouts.admin')

@section('title', 'Sliders')

@section('content')
    <div class="mb-6">
        <div class="bg-gray-900/95 border border-gray-800 rounded-2xl shadow-xl shadow-black/40 px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-lg sm:text-xl font-semibold text-white">Sliders Management</h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
                        Manage homepage slider images and content.
                    </p>
                </div>
                <a href="{{ route('admin.sliders.create') }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-500 text-xs sm:text-sm font-semibold text-white hover:bg-emerald-600 shadow-lg shadow-emerald-500/30">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Slider
                </a>
            </div>

            <form method="GET" action="{{ route('admin.sliders.index') }}" class="mt-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Status</label>
                        <select name="status" class="w-full text-sm rounded-xl border border-gray-700 bg-gray-900/80 text-gray-100 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50">
                            <option value="">All Status</option>
                            <option value="active" @selected(request('status') === 'active')>Active</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-sm font-semibold text-white hover:bg-blue-500 shadow-lg shadow-blue-500/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v3H3V4zm0 5h18v11a1 1 0 01-1 1H4a1 1 0 01-1-1V9z"></path>
                            </svg>
                            Apply Filters
                        </button>
                        @if(request()->has('status'))
                            <a href="{{ route('admin.sliders.index') }}" class="ml-3 inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-600 text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition">
                                Clear
                            </a>
                        @endif
                    </div>
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
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Title</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Subtitle</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Order</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Status</th>
                    <th class="px-4 py-3 text-right text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-gray-950/90 divide-y divide-gray-800">
                @forelse ($sliders as $slider)
                    <tr class="hover:bg-gray-900/80 transition-colors">
                        <td class="px-4 py-3">
                            @if($slider->image)
                                <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" class="w-16 h-12 object-cover rounded-lg border border-gray-700">
                            @else
                                <span class="w-16 h-12 rounded-lg bg-gray-800 flex items-center justify-center text-gray-500 text-xs">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-100">{{ $slider->title }}</td>
                        <td class="px-4 py-3 text-xs text-gray-400">{{ Str::limit($slider->subtitle, 30) ?: '—' }}</td>
                        <td class="px-4 py-3 text-xs text-gray-400">{{ $slider->sort_order }}</td>
                        <td class="px-4 py-3">
                            @if ($slider->is_active)
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-emerald-300 border border-emerald-500/40">Active</span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold bg-gray-700 text-gray-200 border border-gray-600">Inactive</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right">
                            <div class="inline-flex items-center gap-2">
                                <a href="{{ route('admin.sliders.edit', $slider) }}"
                                   class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-500/10 border border-blue-400/60 text-blue-300 hover:bg-blue-500/20" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M4 20h4l9.5-9.5a1.5 1.5 0 00-2.121-2.121L6 17.879 4 20z"></path></svg>
                                </a>
                                <form action="{{ route('admin.sliders.destroy', $slider) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this slider?');">
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
                        <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-400">No sliders found. Create your first slider.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($sliders->hasPages())
            <div class="px-4 py-3 border-t border-gray-800 bg-gray-950/90 flex items-center justify-between text-xs text-gray-400">
                <div>Showing <span class="font-semibold text-gray-200">{{ $sliders->firstItem() ?? 0 }}</span> to <span class="font-semibold text-gray-200">{{ $sliders->lastItem() ?? 0 }}</span> of <span class="font-semibold text-gray-200">{{ $sliders->total() }}</span> sliders</div>
                <div>{{ $sliders->onEachSide(1)->links() }}</div>
            </div>
        @endif
    </div>
@endsection

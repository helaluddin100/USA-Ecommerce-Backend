@extends('layouts.admin')

@section('title', 'Contacts')

@section('content')
    <div class="mb-6">
        <div class="bg-gray-900/95 border border-gray-800 rounded-2xl shadow-xl shadow-black/40 px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-lg sm:text-xl font-semibold text-white">Contact Messages</h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
                        Messages submitted from the contact page.
                    </p>
                </div>
            </div>
            <form method="GET" action="{{ route('admin.contacts.index') }}" class="mt-5">
                <div class="flex gap-4">
                    <div class="flex-1">
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Search</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10 18a8 8 0 100-16 8 8 0 000 16z"></path>
                                </svg>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}"
                                   placeholder="Name, email, subject, message..."
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-gray-700 bg-gray-900/80 text-gray-100 placeholder:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition">
                        </div>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="px-5 py-2.5 rounded-xl bg-blue-600 text-sm font-semibold text-white hover:bg-blue-500">Search</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="bg-gray-950/90 dark:bg-gray-900 rounded-2xl shadow-2xl shadow-black/40 border border-gray-800 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-gray-900/80">
                <tr>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Name</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Email</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Phone</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Subject</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Message</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Date</th>
                </tr>
                </thead>
                <tbody class="bg-gray-950/90 divide-y divide-gray-800">
                @forelse ($contacts as $contact)
                    <tr class="hover:bg-gray-900/80 transition-colors">
                        <td class="px-4 py-3 text-sm font-medium text-gray-100">{{ $contact->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-300">{{ $contact->email }}</td>
                        <td class="px-4 py-3 text-sm text-gray-400">{{ $contact->phone ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-400">{{ $contact->subject ?? '—' }}</td>
                        <td class="px-4 py-3 text-sm text-gray-400 max-w-xs truncate" title="{{ $contact->message }}">{{ Str::limit($contact->message, 50) }}</td>
                        <td class="px-4 py-3 text-xs text-gray-500">{{ $contact->created_at->format('M d, Y H:i') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-sm text-gray-400">No contact messages yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($contacts->hasPages())
            <div class="px-4 py-3 border-t border-gray-800 flex items-center justify-between text-xs text-gray-400">
                <div>Showing {{ $contacts->firstItem() ?? 0 }} to {{ $contacts->lastItem() ?? 0 }} of {{ $contacts->total() }}</div>
                <div>{{ $contacts->links() }}</div>
            </div>
        @endif
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Orders')

@section('content')
    <div class="mb-6">
        <div class="bg-gray-900/95 border border-gray-800 rounded-2xl shadow-xl shadow-black/40 px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
                <div>
                    <h1 class="text-lg sm:text-xl font-semibold text-white">Orders</h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
                        View all orders and payment status.
                    </p>
                </div>
            </div>

            <form method="GET" action="{{ route('admin.orders.index') }}" class="mt-5">
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
                                   placeholder="Order number, email, name..."
                                   class="w-full pl-10 pr-4 py-2.5 text-sm rounded-xl border border-gray-700 bg-gray-900/80 text-gray-100 placeholder:text-gray-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50 transition">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Order Status</label>
                        <select name="status" class="w-full text-sm rounded-xl border border-gray-700 bg-gray-900/80 text-gray-100 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50">
                            <option value="">All</option>
                            <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                            <option value="processing" @selected(request('status') === 'processing')>Processing</option>
                            <option value="shipped" @selected(request('status') === 'shipped')>Shipped</option>
                            <option value="delivered" @selected(request('status') === 'delivered')>Delivered</option>
                            <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-400 mb-2 uppercase tracking-wide">Payment Status</label>
                        <select name="payment_status" class="w-full text-sm rounded-xl border border-gray-700 bg-gray-900/80 text-gray-100 px-4 py-2.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500/50">
                            <option value="">All</option>
                            <option value="pending" @selected(request('payment_status') === 'pending')>Pending</option>
                            <option value="paid" @selected(request('payment_status') === 'paid')>Success</option>
                            <option value="failed" @selected(request('payment_status') === 'failed')>Failed</option>
                            <option value="cancelled" @selected(request('payment_status') === 'cancelled')>Cancelled</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-blue-600 text-sm font-semibold text-white hover:bg-blue-500 shadow-lg shadow-blue-500/20 transition">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v3H3V4zm0 5h18v11a1 1 0 01-1 1H4a1 1 0 01-1-1V9z"></path>
                            </svg>
                            Apply
                        </button>
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
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Order #</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Customer</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Date</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Total</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Order Status</th>
                    <th class="px-4 py-3 text-left text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Payment</th>
                    <th class="px-4 py-3 text-right text-[11px] font-semibold text-gray-400 uppercase tracking-wide">Action</th>
                </tr>
                </thead>
                <tbody class="bg-gray-950/90 divide-y divide-gray-800">
                @forelse ($orders as $order)
                    <tr class="hover:bg-gray-900/80 transition-colors">
                        <td class="px-4 py-3 text-sm font-medium text-gray-100">{{ $order->order_number }}</td>
                        <td class="px-4 py-3 text-sm text-gray-300">
                            {{ $order->customer_name ?: optional($order->user)->name ?: '—' }}<br>
                            <span class="text-xs text-gray-500">{{ $order->customer_email ?: optional($order->user)->email ?: '—' }}</span>
                        </td>
                        <td class="px-4 py-3 text-xs text-gray-400">{{ $order->created_at->format('M d, Y H:i') }}</td>
                        <td class="px-4 py-3 text-sm font-semibold text-gray-200">${{ number_format($order->total, 2) }}</td>
                        <td class="px-4 py-3">
                            @php
                                $statusClass = match($order->status) {
                                    'pending' => 'bg-amber-500/10 text-amber-300 border-amber-500/40',
                                    'processing' => 'bg-blue-500/10 text-blue-300 border-blue-500/40',
                                    'shipped' => 'bg-indigo-500/10 text-indigo-300 border-indigo-500/40',
                                    'delivered' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/40',
                                    'cancelled' => 'bg-red-500/10 text-red-300 border-red-500/40',
                                    default => 'bg-gray-600 text-gray-200 border-gray-500',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="px-4 py-3">
                            @php
                                $payStatus = $order->payment_status ?? 'pending';
                                $payClass = match($payStatus) {
                                    'pending' => 'bg-amber-500/10 text-amber-300 border-amber-500/40',
                                    'paid' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/40',
                                    'failed' => 'bg-red-500/10 text-red-300 border-red-500/40',
                                    'cancelled' => 'bg-red-500/10 text-red-300 border-red-500/40',
                                    default => 'bg-gray-600 text-gray-200 border-gray-500',
                                };
                                $payLabel = match($payStatus) {
                                    'paid' => 'Success',
                                    'failed' => 'Failed',
                                    'cancelled' => 'Cancelled',
                                    default => 'Pending',
                                };
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-[11px] font-semibold border {{ $payClass }}">{{ $payLabel }}</span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ route('admin.orders.show', $order) }}"
                               class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-blue-500/10 border border-blue-400/60 text-blue-300 hover:bg-blue-500/20 text-sm font-medium">
                                View
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-400">No orders found.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
        @if ($orders->hasPages())
            <div class="px-4 py-3 border-t border-gray-800 bg-gray-950/90 flex items-center justify-between text-xs text-gray-400">
                <div>Showing <span class="font-semibold text-gray-200">{{ $orders->firstItem() ?? 0 }}</span> to <span class="font-semibold text-gray-200">{{ $orders->lastItem() ?? 0 }}</span> of <span class="font-semibold text-gray-200">{{ $orders->total() }}</span> orders</div>
                <div>{{ $orders->onEachSide(1)->links() }}</div>
            </div>
        @endif
    </div>
@endsection

@extends('layouts.admin')

@section('title', 'Order ' . $order->order_number)

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-white transition mb-4">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            Back to Orders
        </a>
        <div class="bg-gray-900/95 border border-gray-800 rounded-2xl shadow-xl shadow-black/40 px-4 py-4 sm:px-6 sm:py-5">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <div>
                    <h1 class="text-lg sm:text-xl font-semibold text-white">Order {{ $order->order_number }}</h1>
                    <p class="text-xs sm:text-sm text-gray-400 mt-0.5">
                        {{ $order->created_at->format('F d, Y \a\t H:i') }}
                    </p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @php
                        $statusClass = match($order->status) {
                            'pending' => 'bg-amber-500/10 text-amber-300 border-amber-500/40',
                            'processing' => 'bg-blue-500/10 text-blue-300 border-blue-500/40',
                            'shipped' => 'bg-indigo-500/10 text-indigo-300 border-indigo-500/40',
                            'delivered' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/40',
                            'cancelled' => 'bg-red-500/10 text-red-300 border-red-500/40',
                            default => 'bg-gray-600 text-gray-200 border-gray-500',
                        };
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
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border {{ $statusClass }}">Order: {{ ucfirst($order->status) }}</span>
                    <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-semibold border {{ $payClass }}">Payment: {{ $payLabel }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <div class="bg-gray-950/90 dark:bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-800 bg-gray-900/80">
                <h2 class="text-sm font-semibold text-gray-200">Customer & Shipping</h2>
            </div>
            <div class="p-4 sm:p-6 space-y-3 text-sm">
                <p class="text-gray-100 font-medium">{{ $order->customer_name ?: optional($order->user)->name ?: '—' }}</p>
                <p class="text-gray-400">{{ $order->customer_email ?: optional($order->user)->email ?: '—' }}</p>
                @if($order->customer_phone)
                    <p class="text-gray-400">{{ $order->customer_phone }}</p>
                @endif
                @if($order->shipping_address)
                    <p class="text-gray-400 mt-2 whitespace-pre-line">{{ $order->shipping_address }}</p>
                @endif
                <p class="text-gray-500 text-xs mt-2">Payment method: {{ $order->payment_method ?? '—' }}</p>
            </div>
        </div>
        <div class="bg-gray-950/90 dark:bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-800 bg-gray-900/80">
                <h2 class="text-sm font-semibold text-gray-200">Summary</h2>
            </div>
            <div class="p-4 sm:p-6 space-y-2 text-sm">
                <div class="flex justify-between text-gray-300">
                    <span>Subtotal</span>
                    <span>${{ number_format($order->subtotal, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-300">
                    <span>Shipping</span>
                    <span>${{ number_format($order->shipping, 2) }}</span>
                </div>
                <div class="flex justify-between text-gray-300">
                    <span>Tax</span>
                    <span>${{ number_format($order->tax, 2) }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold text-white pt-2 border-t border-gray-700">
                    <span>Total</span>
                    <span>${{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-gray-950/90 dark:bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden">
        <div class="px-4 py-3 border-b border-gray-800 bg-gray-900/80">
            <h2 class="text-sm font-semibold text-gray-200">Order Items</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-800">
                <thead class="bg-gray-900/60">
                <tr>
                    <th class="px-4 py-2 text-left text-[11px] font-semibold text-gray-400 uppercase">Product</th>
                    <th class="px-4 py-2 text-right text-[11px] font-semibold text-gray-400 uppercase">Qty</th>
                    <th class="px-4 py-2 text-right text-[11px] font-semibold text-gray-400 uppercase">Price</th>
                    <th class="px-4 py-2 text-right text-[11px] font-semibold text-gray-400 uppercase">Subtotal</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-800">
                @foreach($order->items as $item)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-200">{{ $item->product_name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-400 text-right">{{ $item->quantity }}</td>
                        <td class="px-4 py-3 text-sm text-gray-400 text-right">${{ number_format($item->price, 2) }}</td>
                        <td class="px-4 py-3 text-sm font-medium text-gray-200 text-right">${{ number_format($item->price * $item->quantity, 2) }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="bg-gray-950/90 dark:bg-gray-900 rounded-2xl border border-gray-800 overflow-hidden mt-6">
        <div class="px-4 py-3 border-b border-gray-800 bg-gray-900/80">
            <h2 class="text-sm font-semibold text-gray-200">Payment History</h2>
            <p class="text-xs text-gray-500 mt-0.5">Callback/fallback data from payment gateway</p>
        </div>
        <div class="p-4 sm:p-6">
            @forelse($order->paymentHistories as $ph)
                <div class="border border-gray-700 rounded-xl p-4 mb-4 last:mb-0 bg-gray-900/50">
                    <div class="flex flex-wrap items-center justify-between gap-2 mb-2">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="text-sm font-medium text-gray-200">{{ $ph->gateway_name }} / {{ $ph->payment_method }}</span>
                            <span class="text-xs text-gray-500">Order #{{ $ph->order_number }}</span>
                            @php
                                $phStatusClass = match($ph->status) {
                                    'paid' => 'bg-emerald-500/10 text-emerald-300 border-emerald-500/40',
                                    'failed' => 'bg-red-500/10 text-red-300 border-red-500/40',
                                    'cancelled' => 'bg-red-500/10 text-red-300 border-red-500/40',
                                    default => 'bg-amber-500/10 text-amber-300 border-amber-500/40',
                                };
                                $phLabel = match($ph->status) {
                                    'paid' => 'Success',
                                    'failed' => 'Failed',
                                    'cancelled' => 'Cancelled',
                                    default => 'Pending',
                                };
                            @endphp
                            <span class="inline-flex px-2 py-0.5 rounded text-[11px] font-semibold border {{ $phStatusClass }}">{{ $phLabel }}</span>
                        </div>
                        <div class="text-sm">
                            <span class="font-semibold text-white">${{ number_format($ph->amount, 2) }}</span>
                            <span class="text-gray-500"> {{ $ph->currency }}</span>
                        </div>
                    </div>
                    <div class="text-xs text-gray-400 space-y-0.5">
                        <p>At {{ $ph->created_at->format('M d, Y H:i:s') }} @if($ph->transaction_id) · Trx: {{ $ph->transaction_id }} @endif</p>
                        @if($ph->ip_address)
                            <p>IP: {{ $ph->ip_address }}</p>
                        @endif
                    </div>
                    @if($ph->raw_callback && count($ph->raw_callback) > 0)
                        <details class="mt-3">
                            <summary class="text-xs font-medium text-gray-400 cursor-pointer hover:text-gray-300">Full callback data</summary>
                            <pre class="mt-2 p-3 rounded-lg bg-gray-950 text-[11px] text-gray-400 overflow-x-auto border border-gray-800">{{ json_encode($ph->raw_callback, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES) }}</pre>
                        </details>
                    @endif
                </div>
            @empty
                <p class="text-sm text-gray-500">No payment history recorded yet.</p>
            @endforelse
        </div>
    </div>
@endsection

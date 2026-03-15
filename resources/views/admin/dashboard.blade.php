@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Revenue</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        ${{ number_format($stats['total_revenue'], 2) }}</p>
                    <p class="text-green-600 dark:text-green-400 text-sm mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +{{ $stats['revenue_growth'] }}%
                    </p>
                </div>
                <div class="bg-blue-100 dark:bg-blue-900 p-3 rounded-full">
                    <svg class="w-8 h-8 text-blue-600 dark:text-blue-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Orders</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        {{ number_format($stats['total_orders']) }}</p>
                    <p class="text-green-600 dark:text-green-400 text-sm mt-2 flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        +{{ $stats['orders_growth'] }}%
                    </p>
                </div>
                <div class="bg-green-100 dark:bg-green-900 p-3 rounded-full">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Customers</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        {{ number_format($stats['total_customers']) }}</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">Active B2B clients</p>
                </div>
                <div class="bg-purple-100 dark:bg-purple-900 p-3 rounded-full">
                    <svg class="w-8 h-8 text-purple-600 dark:text-purple-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                        </path>
                    </svg>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Total Products</p>
                    <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                        {{ number_format($stats['total_products']) }}</p>
                    <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">In catalog</p>
                </div>
                <div class="bg-orange-100 dark:bg-orange-900 p-3 rounded-full">
                    <svg class="w-8 h-8 text-orange-600 dark:text-orange-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Average Order Value</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                ${{ number_format($stats['average_order_value'], 2) }}</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Conversion Rate</p>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-2">
                {{ number_format($stats['conversion_rate'], 1) }}%</p>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <p class="text-gray-600 dark:text-gray-400 text-sm font-medium">Revenue Growth</p>
            <p class="text-2xl font-bold text-green-600 dark:text-green-400 mt-2">
                +{{ number_format($stats['revenue_growth'], 1) }}%</p>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Revenue Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Revenue Overview</h3>
            <div style="height: 300px;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Orders Chart -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Orders Overview</h3>
            <div style="height: 300px;">
                <canvas id="ordersChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Tables Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
        <!-- Top Customers -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Top Customers</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Customer</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Orders</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($topCustomers as $customer)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $customer['name'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-300">{{ $customer['orders'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-300">
                                        ${{ number_format($customer['revenue'], 2) }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Products -->
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
            <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Top Products</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Product</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Sales</th>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                                Revenue</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach ($topProducts as $product)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                        {{ $product['name'] }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-300">
                                        {{ number_format($product['sales']) }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900 dark:text-gray-300">
                                        ${{ number_format($product['revenue'], 2) }}</div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Recent Orders -->
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow">
        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">Recent Orders</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Order ID</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Customer</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Amount</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Status</th>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Date</th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($recentOrders as $order)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $order['id'] }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-300">{{ $order['customer'] }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-300">
                                    ${{ number_format($order['amount'], 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $statusColors = [
                                        'completed' =>
                                            'bg-green-100 dark:bg-green-900 text-green-800 dark:text-green-200',
                                        'processing' => 'bg-blue-100 dark:bg-blue-900 text-blue-800 dark:text-blue-200',
                                        'pending' =>
                                            'bg-yellow-100 dark:bg-yellow-900 text-yellow-800 dark:text-yellow-200',
                                    ];
                                    $color =
                                        $statusColors[$order['status']] ??
                                        'bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200';
                                @endphp
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                    {{ ucfirst($order['status']) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900 dark:text-gray-300">{{ $order['date'] }}</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Check if Chart is loaded
                if (typeof Chart === 'undefined') {
                    console.error('Chart.js is not loaded');
                    return;
                }

                // Helper function to get chart colors based on theme
                function getChartColors() {
                    const isDark = document.documentElement.classList.contains('dark');
                    return {
                        text: isDark ? '#9CA3AF' : '#6B7280',
                        grid: isDark ? 'rgba(75, 85, 99, 0.3)' : 'rgba(229, 231, 235, 1)',
                        border: isDark ? 'rgb(96, 165, 250)' : 'rgb(59, 130, 246)',
                        background: isDark ? 'rgba(96, 165, 250, 0.1)' : 'rgba(59, 130, 246, 0.1)'
                    };
                }

                // Revenue Chart
                const revenueCanvas = document.getElementById('revenueChart');
                let revenueChart = null;
                if (revenueCanvas) {
                    const revenueCtx = revenueCanvas.getContext('2d');
                    const colors = getChartColors();
                    revenueChart = new Chart(revenueCtx, {
                        type: 'line',
                        data: {
                            labels: @json($monthlySales['labels']),
                            datasets: [{
                                label: 'Revenue',
                                data: @json($monthlySales['revenue']),
                                borderColor: colors.border,
                                backgroundColor: colors.background,
                                tension: 0.4,
                                fill: true
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: colors.text,
                                        callback: function(value) {
                                            return '$' + value.toLocaleString();
                                        }
                                    },
                                    grid: {
                                        color: colors.grid
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: colors.text
                                    },
                                    grid: {
                                        color: colors.grid
                                    }
                                }
                            }
                        }
                    });
                }

                // Orders Chart
                const ordersCanvas = document.getElementById('ordersChart');
                let ordersChart = null;
                if (ordersCanvas) {
                    const ordersCtx = ordersCanvas.getContext('2d');
                    const colors = getChartColors();
                    ordersChart = new Chart(ordersCtx, {
                        type: 'bar',
                        data: {
                            labels: @json($monthlySales['labels']),
                            datasets: [{
                                label: 'Orders',
                                data: @json($monthlySales['orders']),
                                backgroundColor: document.documentElement.classList.contains('dark') ?
                                    'rgba(74, 222, 128, 0.8)' : 'rgba(34, 197, 94, 0.8)',
                                borderColor: document.documentElement.classList.contains('dark') ?
                                    'rgb(74, 222, 128)' : 'rgb(34, 197, 94)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        color: colors.text
                                    },
                                    grid: {
                                        color: colors.grid
                                    }
                                },
                                x: {
                                    ticks: {
                                        color: colors.text
                                    },
                                    grid: {
                                        color: colors.grid
                                    }
                                }
                            }
                        }
                    });
                }

                // Update charts when theme changes
                const observer = new MutationObserver(function(mutations) {
                    mutations.forEach(function(mutation) {
                        if (mutation.attributeName === 'class') {
                            const colors = getChartColors();
                            const isDark = document.documentElement.classList.contains('dark');

                            if (revenueChart) {
                                revenueChart.data.datasets[0].borderColor = colors.border;
                                revenueChart.data.datasets[0].backgroundColor = colors.background;
                                revenueChart.options.scales.y.ticks.color = colors.text;
                                revenueChart.options.scales.y.grid.color = colors.grid;
                                revenueChart.options.scales.x.ticks.color = colors.text;
                                revenueChart.options.scales.x.grid.color = colors.grid;
                                revenueChart.update();
                            }

                            if (ordersChart) {
                                ordersChart.data.datasets[0].backgroundColor = isDark ?
                                    'rgba(74, 222, 128, 0.8)' : 'rgba(34, 197, 94, 0.8)';
                                ordersChart.data.datasets[0].borderColor = isDark ?
                                    'rgb(74, 222, 128)' : 'rgb(34, 197, 94)';
                                ordersChart.options.scales.y.ticks.color = colors.text;
                                ordersChart.options.scales.y.grid.color = colors.grid;
                                ordersChart.options.scales.x.ticks.color = colors.text;
                                ordersChart.options.scales.x.grid.color = colors.grid;
                                ordersChart.update();
                            }
                        }
                    });
                });

                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            });
        </script>
    @endpush
@endsection

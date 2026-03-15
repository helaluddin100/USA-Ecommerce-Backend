<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        $now = now();
        $last30Start = $now->copy()->subDays(30);
        $prev30Start = $now->copy()->subDays(60);

        // Total revenue (all orders)
        $totalRevenue = (float) Order::sum('total');
        $totalOrders = Order::count();
        $totalProducts = Product::count();

        // Order amounts by payment status
        $totalOrdersAmount = $totalRevenue;
        $failedOrdersCount = Order::where('payment_status', 'failed')->count();
        $failedOrdersAmount = (float) Order::where('payment_status', 'failed')->sum('total');
        $successOrdersCount = Order::where('payment_status', 'paid')->count();
        $successOrdersAmount = (float) Order::where('payment_status', 'paid')->sum('total');
        $pendingOrdersCount = Order::where(function ($q) {
            $q->where('payment_status', 'pending')->orWhereNull('payment_status');
        })->count();
        $pendingOrdersAmount = (float) Order::where(function ($q) {
            $q->where('payment_status', 'pending')->orWhereNull('payment_status');
        })->sum('total');
        $cancelledOrdersCount = Order::where('payment_status', 'cancelled')->count();
        $cancelledOrdersAmount = (float) Order::where('payment_status', 'cancelled')->sum('total');

        // Unique customers: distinct by customer_email or 'u'+user_id
        $customersCount = Order::selectRaw("COALESCE(customer_email, CONCAT('u', COALESCE(user_id, 0))) as k")
            ->distinct()
            ->pluck('k')
            ->count();
        $totalCustomers = $customersCount;

        // Average order value
        $averageOrderValue = $totalOrders > 0 ? round($totalRevenue / $totalOrders, 2) : 0;

        // Revenue growth: last 30 days vs previous 30 days
        $revenueLast30 = (float) Order::where('created_at', '>=', $last30Start)->sum('total');
        $revenuePrev30 = (float) Order::where('created_at', '>=', $prev30Start)->where('created_at', '<', $last30Start)->sum('total');
        $revenueGrowth = $revenuePrev30 > 0
            ? round((($revenueLast30 - $revenuePrev30) / $revenuePrev30) * 100, 1)
            : ($revenueLast30 > 0 ? 100 : 0);

        // Orders growth
        $ordersLast30 = Order::where('created_at', '>=', $last30Start)->count();
        $ordersPrev30 = Order::where('created_at', '>=', $prev30Start)->where('created_at', '<', $last30Start)->count();
        $ordersGrowth = $ordersPrev30 > 0
            ? round((($ordersLast30 - $ordersPrev30) / $ordersPrev30) * 100, 1)
            : ($ordersLast30 > 0 ? 100 : 0);

        // Conversion rate: we don't have visitors; use orders/products ratio as placeholder or 0
        $conversionRate = $totalProducts > 0 ? round(($totalOrders / max(1, $totalProducts)) * 100, 1) : 0;

        $stats = [
            'total_revenue' => $totalRevenue,
            'total_orders' => $totalOrders,
            'total_customers' => $totalCustomers,
            'total_products' => $totalProducts,
            'average_order_value' => $averageOrderValue,
            'conversion_rate' => min(100, $conversionRate),
            'revenue_growth' => $revenueGrowth,
            'orders_growth' => $ordersGrowth,
            // Order & payment breakdown
            'total_orders_amount' => $totalOrdersAmount,
            'failed_orders_count' => $failedOrdersCount,
            'failed_orders_amount' => $failedOrdersAmount,
            'success_orders_count' => $successOrdersCount,
            'success_orders_amount' => $successOrdersAmount,
            'pending_orders_count' => $pendingOrdersCount,
            'pending_orders_amount' => $pendingOrdersAmount,
            'cancelled_orders_count' => $cancelledOrdersCount,
            'cancelled_orders_amount' => $cancelledOrdersAmount,
        ];

        // Last 12 months: labels and revenue/orders per month
        $monthlySales = [
            'labels' => [],
            'revenue' => [],
            'orders' => [],
        ];
        for ($i = 11; $i >= 0; $i--) {
            $monthStart = $now->copy()->subMonths($i)->startOfMonth();
            $monthEnd = $monthStart->copy()->endOfMonth();
            $monthlySales['labels'][] = $monthStart->format('M');
            $monthlySales['revenue'][] = (float) Order::whereBetween('created_at', [$monthStart, $monthEnd])->sum('total');
            $monthlySales['orders'][] = Order::whereBetween('created_at', [$monthStart, $monthEnd])->count();
        }

        // Top customers by revenue (unique by email or user)
        $ordersForCustomers = Order::with('user')->get();
        $byCustomer = $ordersForCustomers->groupBy(function ($o) {
            return $o->customer_email ?? 'u' . (int) $o->user_id;
        });
        $topCustomers = $byCustomer->map(function ($group) {
            $first = $group->first();
            return [
                'name' => $first->customer_name ?: $first->user?->name ?? 'Guest',
                'orders' => $group->count(),
                'revenue' => (float) $group->sum('total'),
            ];
        })->sortByDesc('revenue')->take(5)->values()->toArray();

        // Top products by revenue (from order_items)
        $topProducts = OrderItem::query()
            ->select('product_name')
            ->selectRaw('SUM(quantity) as sales')
            ->selectRaw('SUM(quantity * price) as revenue')
            ->groupBy('product_name')
            ->orderByDesc('revenue')
            ->limit(5)
            ->get()
            ->map(fn ($r) => [
                'name' => $r->product_name,
                'sales' => (int) $r->sales,
                'revenue' => (float) $r->revenue,
            ])
            ->toArray();

        // Recent orders
        $recentOrders = Order::with('user')
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($order) {
                $status = $order->payment_status ?? $order->status ?? 'pending';
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer' => $order->customer_name ?: $order->user?->name ?? $order->customer_email ?? '—',
                    'amount' => (float) $order->total,
                    'status' => $status,
                    'date' => $order->created_at->format('Y-m-d'),
                ];
            })
            ->toArray();

        return view('admin.dashboard', compact('stats', 'monthlySales', 'topCustomers', 'topProducts', 'recentOrders'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Mock data for B2B analytics - replace with actual database queries
        $stats = [
            'total_revenue' => 1250000,
            'total_orders' => 3420,
            'total_customers' => 856,
            'total_products' => 1240,
            'average_order_value' => 365.50,
            'conversion_rate' => 3.2,
            'revenue_growth' => 12.5,
            'orders_growth' => 8.3,
        ];

        // Sales data for last 12 months
        $monthlySales = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'revenue' => [85000, 92000, 78000, 105000, 112000, 98000, 125000, 118000, 132000, 145000, 138000, 150000],
            'orders' => [280, 310, 265, 340, 365, 320, 410, 390, 435, 480, 455, 490],
        ];

        // Top customers
        $topCustomers = [
            ['name' => 'ABC Corporation', 'orders' => 145, 'revenue' => 125000],
            ['name' => 'XYZ Industries', 'orders' => 132, 'revenue' => 118000],
            ['name' => 'Global Trading Co.', 'orders' => 128, 'revenue' => 112000],
            ['name' => 'Tech Solutions Ltd.', 'orders' => 115, 'revenue' => 98000],
            ['name' => 'Manufacturing Inc.', 'orders' => 108, 'revenue' => 92000],
        ];

        // Top products
        $topProducts = [
            ['name' => 'Product A', 'sales' => 1240, 'revenue' => 186000],
            ['name' => 'Product B', 'sales' => 1120, 'revenue' => 168000],
            ['name' => 'Product C', 'sales' => 980, 'revenue' => 147000],
            ['name' => 'Product D', 'sales' => 850, 'revenue' => 127500],
            ['name' => 'Product E', 'sales' => 720, 'revenue' => 108000],
        ];

        // Recent orders
        $recentOrders = [
            ['id' => '#ORD-001', 'customer' => 'ABC Corporation', 'amount' => 12500, 'status' => 'completed', 'date' => '2024-12-28'],
            ['id' => '#ORD-002', 'customer' => 'XYZ Industries', 'amount' => 9800, 'status' => 'processing', 'date' => '2024-12-28'],
            ['id' => '#ORD-003', 'customer' => 'Global Trading Co.', 'amount' => 15200, 'status' => 'completed', 'date' => '2024-12-27'],
            ['id' => '#ORD-004', 'customer' => 'Tech Solutions Ltd.', 'amount' => 8700, 'status' => 'pending', 'date' => '2024-12-27'],
            ['id' => '#ORD-005', 'customer' => 'Manufacturing Inc.', 'amount' => 11200, 'status' => 'completed', 'date' => '2024-12-26'],
        ];

        return view('admin.dashboard', compact('stats', 'monthlySales', 'topCustomers', 'topProducts', 'recentOrders'));
    }
}


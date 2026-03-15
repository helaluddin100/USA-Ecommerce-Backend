<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BulkOrderController extends Controller
{
    public function index()
    {
        // Mock data for bulk orders
        $bulkOrders = [
            [
                'id' => 'BULK-001',
                'customer' => 'ABC Corporation',
                'items' => 25,
                'total_quantity' => 5000,
                'total_amount' => 125000,
                'status' => 'pending',
                'created_at' => '2024-12-28',
            ],
            [
                'id' => 'BULK-002',
                'customer' => 'XYZ Industries',
                'items' => 18,
                'total_quantity' => 3500,
                'total_amount' => 98000,
                'status' => 'processing',
                'created_at' => '2024-12-27',
            ],
            [
                'id' => 'BULK-003',
                'customer' => 'Global Trading Co.',
                'items' => 32,
                'total_quantity' => 7200,
                'total_amount' => 152000,
                'status' => 'completed',
                'created_at' => '2024-12-26',
            ],
        ];

        return view('admin.bulk-orders.index', compact('bulkOrders'));
    }

    public function create()
    {
        return view('admin.bulk-orders.create');
    }
}


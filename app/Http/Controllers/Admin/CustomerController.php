<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        // Mock data for B2B customers
        $customers = [
            [
                'id' => 1,
                'company_name' => 'ABC Corporation',
                'contact_person' => 'John Doe',
                'email' => 'john@abccorp.com',
                'phone' => '+1-234-567-8900',
                'total_orders' => 145,
                'total_spent' => 1250000,
                'pricing_tier' => 'Tier 1 - Enterprise',
                'status' => 'active',
                'joined_date' => '2023-01-15',
            ],
            [
                'id' => 2,
                'company_name' => 'XYZ Industries',
                'contact_person' => 'Jane Smith',
                'email' => 'jane@xyzind.com',
                'phone' => '+1-234-567-8901',
                'total_orders' => 132,
                'total_spent' => 1180000,
                'pricing_tier' => 'Tier 1 - Enterprise',
                'status' => 'active',
                'joined_date' => '2023-02-20',
            ],
            [
                'id' => 3,
                'company_name' => 'Global Trading Co.',
                'contact_person' => 'Mike Johnson',
                'email' => 'mike@globaltrade.com',
                'phone' => '+1-234-567-8902',
                'total_orders' => 128,
                'total_spent' => 1120000,
                'pricing_tier' => 'Tier 2 - Business',
                'status' => 'active',
                'joined_date' => '2023-03-10',
            ],
            [
                'id' => 4,
                'company_name' => 'Tech Solutions Ltd.',
                'contact_person' => 'Sarah Williams',
                'email' => 'sarah@techsol.com',
                'phone' => '+1-234-567-8903',
                'total_orders' => 115,
                'total_spent' => 980000,
                'pricing_tier' => 'Tier 2 - Business',
                'status' => 'active',
                'joined_date' => '2023-04-05',
            ],
            [
                'id' => 5,
                'company_name' => 'Manufacturing Inc.',
                'contact_person' => 'David Brown',
                'email' => 'david@mfginc.com',
                'phone' => '+1-234-567-8904',
                'total_orders' => 108,
                'total_spent' => 920000,
                'pricing_tier' => 'Tier 2 - Business',
                'status' => 'active',
                'joined_date' => '2023-05-12',
            ],
        ];

        return view('admin.customers.index', compact('customers'));
    }

    public function show($id)
    {
        // Mock customer detail
        $customer = [
            'id' => $id,
            'company_name' => 'ABC Corporation',
            'contact_person' => 'John Doe',
            'email' => 'john@abccorp.com',
            'phone' => '+1-234-567-8900',
            'address' => '123 Business St, Suite 100',
            'city' => 'New York',
            'state' => 'NY',
            'zip' => '10001',
            'country' => 'USA',
            'tax_id' => 'TAX-123456789',
            'total_orders' => 145,
            'total_spent' => 1250000,
            'average_order_value' => 8620.69,
            'pricing_tier' => 'Tier 1 - Enterprise',
            'status' => 'active',
            'joined_date' => '2023-01-15',
        ];

        return view('admin.customers.show', compact('customer'));
    }
}


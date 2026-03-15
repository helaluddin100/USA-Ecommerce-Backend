<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PricingTierController extends Controller
{
    public function index()
    {
        // Mock data for pricing tiers
        $pricingTiers = [
            [
                'id' => 1,
                'name' => 'Tier 1 - Enterprise',
                'min_quantity' => 1000,
                'discount' => 25,
                'customers' => 45,
                'description' => 'Best pricing for large volume orders',
            ],
            [
                'id' => 2,
                'name' => 'Tier 2 - Business',
                'min_quantity' => 500,
                'discount' => 15,
                'customers' => 120,
                'description' => 'Great pricing for medium volume orders',
            ],
            [
                'id' => 3,
                'name' => 'Tier 3 - Standard',
                'min_quantity' => 100,
                'discount' => 5,
                'customers' => 350,
                'description' => 'Standard pricing for regular orders',
            ],
            [
                'id' => 4,
                'name' => 'Tier 4 - Starter',
                'min_quantity' => 1,
                'discount' => 0,
                'customers' => 341,
                'description' => 'Base pricing for new customers',
            ],
        ];

        return view('admin.pricing-tiers.index', compact('pricingTiers'));
    }

    public function create()
    {
        return view('admin.pricing-tiers.create');
    }
}


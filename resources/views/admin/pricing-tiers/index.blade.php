@extends('layouts.admin')

@section('title', 'Pricing Tiers')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Pricing Tiers Management</h2>
        <a href="{{ route('admin.pricing-tiers.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
            Create New Tier
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($pricingTiers as $tier)
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $tier['name'] }}</h3>
                <span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded">
                    {{ $tier['discount'] }}% OFF
                </span>
            </div>
            <p class="text-gray-600 text-sm mb-4">{{ $tier['description'] }}</p>
            <div class="space-y-2 mb-4">
                <div class="flex justify-between">
                    <span class="text-gray-600 text-sm">Min Quantity:</span>
                    <span class="text-gray-900 font-medium">{{ number_format($tier['min_quantity']) }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 text-sm">Discount:</span>
                    <span class="text-green-600 font-medium">{{ $tier['discount'] }}%</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600 text-sm">Customers:</span>
                    <span class="text-gray-900 font-medium">{{ $tier['customers'] }}</span>
                </div>
            </div>
            <div class="flex space-x-2 mt-4">
                <a href="#" class="flex-1 bg-blue-600 text-white text-center px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    Edit
                </a>
                <a href="#" class="flex-1 bg-gray-100 text-gray-700 text-center px-4 py-2 rounded-lg hover:bg-gray-200 transition-colors text-sm">
                    View
                </a>
            </div>
        </div>
        @endforeach
    </div>
@endsection


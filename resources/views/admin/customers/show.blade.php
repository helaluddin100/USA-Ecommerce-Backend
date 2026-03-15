@extends('layouts.admin')

@section('title', 'Customer Details')

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.customers.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Back to Customers
        </a>
        <h2 class="text-2xl font-bold text-gray-900">{{ $customer['company_name'] }}</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Customer Info Card -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Company Information</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-600">Company Name</label>
                    <p class="text-gray-900 font-medium">{{ $customer['company_name'] }}</p>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-600">Contact Person</label>
                        <p class="text-gray-900 font-medium">{{ $customer['contact_person'] }}</p>
                    </div>
                    <div>
                        <label class="text-sm text-gray-600">Email</label>
                        <p class="text-gray-900 font-medium">{{ $customer['email'] }}</p>
                    </div>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Phone</label>
                    <p class="text-gray-900 font-medium">{{ $customer['phone'] }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Address</label>
                    <p class="text-gray-900 font-medium">{{ $customer['address'] }}</p>
                    <p class="text-gray-900">{{ $customer['city'] }}, {{ $customer['state'] }} {{ $customer['zip'] }}</p>
                    <p class="text-gray-900">{{ $customer['country'] }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Tax ID</label>
                    <p class="text-gray-900 font-medium">{{ $customer['tax_id'] }}</p>
                </div>
            </div>
        </div>

        <!-- Stats Card -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4">Statistics</h3>
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-600">Total Orders</label>
                    <p class="text-2xl font-bold text-gray-900">{{ $customer['total_orders'] }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Total Spent</label>
                    <p class="text-2xl font-bold text-blue-600">${{ number_format($customer['total_spent'], 2) }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Average Order Value</label>
                    <p class="text-xl font-semibold text-gray-900">${{ number_format($customer['average_order_value'], 2) }}</p>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Pricing Tier</label>
                    <span class="inline-block mt-1 px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-800">
                        {{ $customer['pricing_tier'] }}
                    </span>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Status</label>
                    <span class="inline-block mt-1 px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-800">
                        {{ ucfirst($customer['status']) }}
                    </span>
                </div>
                <div>
                    <label class="text-sm text-gray-600">Member Since</label>
                    <p class="text-gray-900 font-medium">{{ $customer['joined_date'] }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex space-x-3">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                Edit Customer
            </button>
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition-colors">
                Create Order
            </button>
            <button class="bg-gray-200 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-300 transition-colors">
                View Orders
            </button>
        </div>
    </div>
@endsection


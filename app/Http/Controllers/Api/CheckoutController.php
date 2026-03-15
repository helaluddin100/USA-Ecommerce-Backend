<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\EpsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Create order from cart payload (guest or logged-in) and return EPS payment URL.
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'items' => ['required', 'array', 'min:1'],
            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],
            'items.*.quantity' => ['required', 'integer', 'min:1', 'max:10'],
            'items.*.price' => ['required', 'numeric', 'min:0'],
            'items.*.name' => ['required', 'string', 'max:255'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'shipping_address' => ['required', 'string'],
            'success_url' => ['nullable', 'string', 'url'],
            'cancel_url' => ['nullable', 'string', 'url'],
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }

        $data = $validator->validated();
        $items = $data['items'];

        $subtotal = 0;
        foreach ($items as $row) {
            $subtotal += (float) $row['price'] * (int) $row['quantity'];
        }
        $shipping = 0;
        $tax = 0;
        $total = $subtotal + $shipping + $tax;

        $userId = $request->user()?->id;

        $order = Order::create([
            'user_id' => $userId,
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'shipping_address' => $data['shipping_address'],
            'payment_method' => 'eps',
            'customer_name' => $data['customer_name'],
            'customer_email' => $data['customer_email'],
            'customer_phone' => $data['customer_phone'] ?? null,
        ]);

        foreach ($items as $row) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => (int) $row['product_id'],
                'quantity' => (int) $row['quantity'],
                'price' => (float) $row['price'],
                'product_name' => $row['name'],
            ]);
        }

        $successUrl = $data['success_url'] ?? config('services.eps.success_url', '');
        $cancelUrl = $data['cancel_url'] ?? config('services.eps.cancel_url', '');
        $eps = new EpsService();
        $paymentUrl = $eps->hasCredentials()
            ? $eps->createPaymentLink($order, $successUrl, $cancelUrl)
            : null;
        // Do NOT redirect to sandbox base URL with query params - that shows a blank page.
        // When EPS API does not return a real payment link, send user to our success page with pending flag.
        if (! $paymentUrl && $successUrl) {
            $paymentUrl = $this->appendQueryParams($successUrl, [
                'order' => $order->order_number,
                'pending' => '1',
            ]);
        } elseif (! $paymentUrl) {
            $paymentUrl = $this->appendQueryParams(config('app.frontend_url', ''), [
                'order' => $order->order_number,
                'pending' => '1',
            ]);
        }

        $order->load('items');

        return response()->json([
            'order' => $order,
            'payment_url' => $paymentUrl,
        ], 201);
    }

    private function appendQueryParams(string $url, array $params): string
    {
        $params = array_filter($params);
        if (empty($params)) {
            return $url;
        }
        $separator = str_contains($url, '?') ? '&' : '?';
        return $url . $separator . http_build_query($params);
    }
}

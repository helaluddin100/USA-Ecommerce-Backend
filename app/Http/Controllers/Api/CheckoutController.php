<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\EpsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Payment return/callback: EPS redirects here after payment. Update order payment_status and redirect to frontend.
     */
    public function paymentReturn(Request $request): RedirectResponse|JsonResponse
    {
        $orderNumber = $request->query('order');
        $outcome = $request->query('outcome', '');
        $redirectTo = $request->query('redirect');

        if (! $orderNumber) {
            return $redirectTo ? redirect($redirectTo) : response()->json(['message' => 'Missing order'], 422);
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if ($order) {
            $status = match (strtolower($outcome)) {
                'success' => 'paid',
                'failed' => 'failed',
                'cancelled', 'cancel' => 'cancelled',
                default => null,
            };
            if ($status) {
                $order->update(['payment_status' => $status]);
            }
        }

        if (! $redirectTo) {
            return response()->json(['message' => 'Order updated', 'order' => $order?->order_number]);
        }

        $url = $redirectTo;
        $separator = str_contains($url, '?') ? '&' : '?';
        $url .= $separator . http_build_query(array_filter([
            'order' => $order?->order_number,
            'payment' => $order ? ($order->payment_status ?? 'pending') : 'pending',
        ]));

        return redirect($url);
    }

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
            'payment_status' => 'pending',
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

        $frontendSuccess = $data['success_url'] ?? config('services.eps.success_url', '');
        $frontendCancel = $data['cancel_url'] ?? config('services.eps.cancel_url', '');
        $backendBase = rtrim(config('app.url'), '/');
        $successCallback = $backendBase . '/api/checkout/payment-return?order=' . urlencode($order->order_number) . '&outcome=success&redirect=' . urlencode($frontendSuccess);
        $cancelCallback = $backendBase . '/api/checkout/payment-return?order=' . urlencode($order->order_number) . '&outcome=cancelled&redirect=' . urlencode($frontendCancel);
        $failCallback = $backendBase . '/api/checkout/payment-return?order=' . urlencode($order->order_number) . '&outcome=failed&redirect=' . urlencode($frontendSuccess);
        $eps = new EpsService();
        $paymentUrl = $eps->hasCredentials()
            ? $eps->createPaymentLink($order, $successCallback, $cancelCallback, $failCallback)
            : null;
        // Do NOT redirect to sandbox base URL with query params - that shows a blank page.
        // When EPS API does not return a real payment link, send user to our success page with pending flag.
        if (! $paymentUrl && $frontendSuccess) {
            $paymentUrl = $this->appendQueryParams($frontendSuccess, [
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

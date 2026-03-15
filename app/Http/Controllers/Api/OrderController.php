<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Public: track order by order_number + customer_email (for guest orders).
     */
    public function track(Request $request): JsonResponse
    {
        $orderNumber = $request->query('order_number');
        $email = $request->query('email');
        if (! $orderNumber || ! $email) {
            return response()->json(['message' => 'order_number and email are required'], 422);
        }
        $order = Order::where('order_number', $orderNumber)
            ->where('customer_email', $email)
            ->with('items')
            ->first();
        if (! $order) {
            return response()->json(['message' => 'Order not found'], 404);
        }
        return response()->json($order);
    }

    public function index(Request $request): JsonResponse
    {
        $orders = $request->user()->orders()->with('items')->latest()->paginate(15);

        return response()->json($orders);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'shipping_address' => ['nullable', 'string'],
            'payment_method' => ['nullable', 'string', 'max:50'],
        ]);

        $cartItems = $request->user()->cartItems()->with('product')->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Cart is empty'], 422);
        }

        $subtotal = $cartItems->sum(fn ($item) => $item->product->price * $item->quantity);
        $shipping = 0;
        $tax = 0;
        $total = $subtotal + $shipping + $tax;

        $order = Order::create([
            'user_id' => $request->user()->id,
            'order_number' => Order::generateOrderNumber(),
            'status' => 'pending',
            'subtotal' => $subtotal,
            'shipping' => $shipping,
            'tax' => $tax,
            'total' => $total,
            'shipping_address' => $validated['shipping_address'] ?? null,
            'payment_method' => $validated['payment_method'] ?? 'cod',
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'product_name' => $item->product->name,
            ]);
        }

        $request->user()->cartItems()->delete();

        $order->load('items.product');

        return response()->json($order, 201);
    }

    public function show(Request $request, Order $order): JsonResponse
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $order->load('items.product');

        return response()->json($order);
    }
}

<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\WishlistItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $items = $request->user()->wishlistItems()->with('product.category')->get();

        return response()->json($items);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $product = Product::findOrFail($validated['product_id']);

        if (!$product->is_active) {
            return response()->json(['message' => 'Product not available'], 422);
        }

        $item = WishlistItem::firstOrCreate(
            [
                'user_id' => $request->user()->id,
                'product_id' => $validated['product_id'],
            ]
        );

        $item->load('product');

        return response()->json($item, 201);
    }

    public function destroy(Request $request, WishlistItem $wishlistItem): JsonResponse
    {
        if ($wishlistItem->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $wishlistItem->delete();

        return response()->json(['message' => 'Removed from wishlist']);
    }
}

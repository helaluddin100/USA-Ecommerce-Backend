<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }
        if ($request->has('is_new') && $request->boolean('is_new')) {
            $query->where('is_new', true);
        }
        if ($request->has('on_sale') && $request->boolean('on_sale')) {
            $query->where('on_sale', true);
        }
        if ($request->has('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 15));

        return response()->json($products);
    }

    public function show(Product $product): JsonResponse
    {
        if (!$product->is_active) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $product->load('category');

        return response()->json($product);
    }
}

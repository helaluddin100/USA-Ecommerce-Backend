<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Product::with('category')->where('is_active', true);

        if ($request->has('category_id')) {
            $ids = is_array($request->category_id) ? $request->category_id : [$request->category_id];
            $ids = array_filter(array_map('intval', $ids));
            if (!empty($ids)) {
                $query->whereIn('category_id', $ids);
            }
        }
        if ($request->has('is_new') && $request->boolean('is_new')) {
            $query->where('is_new', true);
        }
        if ($request->has('on_sale') && $request->boolean('on_sale')) {
            $query->where('on_sale', true);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }
        if ($request->filled('price_min') && is_numeric($request->price_min)) {
            $query->where('price', '>=', (float) $request->price_min);
        }
        if ($request->filled('price_max') && is_numeric($request->price_max)) {
            $query->where('price', '<=', (float) $request->price_max);
        }

        $sort = $request->get('sort', 'newest');
        match ($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'name' => $query->orderBy('name', 'asc'),
            'newest' => $query->orderBy('created_at', 'desc'),
            default => $query->orderBy('created_at', 'desc'),
        };

        $products = $query->paginate($request->get('per_page', 15));

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

    public function showBySlug(string $slug): JsonResponse
    {
        $product = Product::where('is_active', true)
            ->with('category')
            ->where(function ($q) use ($slug) {
                $q->where('slug', $slug);
                if (is_numeric($slug)) {
                    $q->orWhere('id', (int) $slug);
                }
            })
            ->first();

        if (!$product) {
            $product = Product::where('is_active', true)
                ->with('category')
                ->get()
                ->first(fn (Product $p) => Str::slug($p->name) === $slug);
        }

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        return response()->json($product);
    }
}

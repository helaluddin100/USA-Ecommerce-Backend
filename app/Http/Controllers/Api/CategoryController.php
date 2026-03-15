<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    public function index(): JsonResponse
    {
        $categories = Category::where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->withCount('products')
            ->get();

        return response()->json($categories);
    }

    public function show(Category $category): JsonResponse
    {
        if (!$category->is_active) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->load('products');

        return response()->json($category);
    }
}

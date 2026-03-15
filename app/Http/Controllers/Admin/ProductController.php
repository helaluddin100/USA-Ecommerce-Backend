<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('slug', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        if ($categoryId = $request->get('category_id')) {
            $query->where('category_id', $categoryId);
        }

        if ($status = $request->get('status')) {
            if ($status === 'active') {
                $query->where('is_active', true);
            } elseif ($status === 'inactive') {
                $query->where('is_active', false);
            }
        }

        $sort = $request->get('sort', 'created_at');
        if ($sort === 'name') {
            $query->orderBy('name');
        } elseif ($sort === 'price_asc') {
            $query->orderBy('price');
        } elseif ($sort === 'price_desc') {
            $query->orderByDesc('price');
        } else {
            $query->orderByDesc('created_at');
        }

        $products = $query->paginate(15)->appends($request->only(['search', 'category_id', 'status', 'sort']));
        $categories = Category::orderBy('sort_order')->orderBy('name')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'badge' => ['nullable', 'string', 'max:50'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'is_new' => ['nullable', 'boolean'],
            'on_sale' => ['nullable', 'boolean'],
            'is_active' => ['required', 'boolean'],
        ]);

        $data['slug'] = trim((string) ($data['slug'] ?? '')) !== '' ? $data['slug'] : Str::slug($data['name']);
        $data['is_new'] = (bool) ($request->boolean('is_new'));
        $data['on_sale'] = (bool) ($request->boolean('on_sale'));
        $data['stock'] = (int) ($data['stock'] ?? 0);

        if ($request->hasFile('image_file')) {
            $data['image'] = $this->uploadProductImage($request->file('image_file'));
        } else {
            $data['image'] = $request->input('image'); // emoji or URL fallback
        }

        unset($data['image_file']);
        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::where('is_active', true)->orderBy('sort_order')->orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug,' . $product->id],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0'],
            'image' => ['nullable', 'string'],
            'image_file' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'badge' => ['nullable', 'string', 'max:50'],
            'stock' => ['nullable', 'integer', 'min:0'],
            'is_new' => ['nullable', 'boolean'],
            'on_sale' => ['nullable', 'boolean'],
            'is_active' => ['required', 'boolean'],
        ]);

        $data['slug'] = trim((string) ($data['slug'] ?? '')) !== '' ? $data['slug'] : Str::slug($data['name']);
        $data['is_new'] = (bool) ($request->boolean('is_new'));
        $data['on_sale'] = (bool) ($request->boolean('on_sale'));
        $data['stock'] = (int) ($data['stock'] ?? 0);

        if ($request->hasFile('image_file')) {
            if ($product->image && !str_starts_with($product->image, 'http') && $product->image !== '') {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $this->uploadProductImage($request->file('image_file'));
        } else {
            $data['image'] = $request->input('image', $product->image);
        }

        unset($data['image_file']);
        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if ($product->image && !str_starts_with($product->image, 'http')) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }

    private function uploadProductImage($file): string
    {
        $manager = new ImageManager(new Driver());
        $image = $manager->read($file->getRealPath());
        $filename = 'product_' . uniqid() . '.webp';
        $path = 'products/' . $filename;
        Storage::disk('public')->put($path, (string) $image->toWebp());
        return $path;
    }
}

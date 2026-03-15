<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Wireless Bluetooth Headphones', 'slug' => 'wireless-bluetooth-headphones', 'price' => 79.99, 'old_price' => 99.99, 'image' => '🎧', 'badge' => 'New', 'description' => 'Premium sound, 30hr battery. Comfortable over-ear design.', 'category' => 'electronics', 'is_new' => true, 'on_sale' => true],
            ['name' => 'Smart Watch Pro', 'slug' => 'smart-watch-pro', 'price' => 199.99, 'image' => '⌚', 'badge' => 'New', 'description' => 'Heart rate, GPS, 7-day battery. Water resistant.', 'category' => 'electronics', 'is_new' => true, 'on_sale' => false],
            ['name' => 'Minimalist Backpack', 'slug' => 'minimalist-backpack', 'price' => 49.99, 'old_price' => 65, 'image' => '🎒', 'badge' => 'New', 'description' => 'Lightweight, laptop sleeve. Durable water-resistant fabric.', 'category' => 'fashion', 'is_new' => true, 'on_sale' => true],
            ['name' => 'Organic Cotton T-Shirt', 'slug' => 'organic-cotton-tshirt', 'price' => 29.99, 'image' => '👕', 'badge' => 'New', 'description' => 'Soft, breathable organic cotton. Unisex fit.', 'category' => 'fashion', 'is_new' => true, 'on_sale' => false],
            ['name' => 'Laptop Stand Aluminum', 'slug' => 'laptop-stand-aluminum', 'price' => 45.99, 'image' => '💻', 'description' => 'Ergonomic angle, sturdy aluminum. Fits all laptops.', 'category' => 'electronics', 'is_new' => false, 'on_sale' => false],
            ['name' => 'Running Shoes Sport', 'slug' => 'running-shoes-sport', 'price' => 89.99, 'old_price' => 120, 'image' => '👟', 'badge' => 'Best Seller', 'description' => 'Cushioned sole, breathable mesh. For daily runs.', 'category' => 'sports', 'is_new' => false, 'on_sale' => true],
            ['name' => 'Portable Power Bank 20000mAh', 'slug' => 'portable-power-bank', 'price' => 39.99, 'image' => '🔋', 'description' => 'Fast charging, dual USB. Compact and travel-friendly.', 'category' => 'electronics', 'is_new' => false, 'on_sale' => false],
            ['name' => 'Stainless Steel Water Bottle', 'slug' => 'stainless-steel-water-bottle', 'price' => 24.99, 'image' => '🥤', 'badge' => 'Best Seller', 'description' => 'Insulated, BPA-free. Keeps drinks cold 24hrs.', 'category' => 'home-garden', 'is_new' => false, 'on_sale' => false],
            ['name' => 'Yoga Mat Premium', 'slug' => 'yoga-mat-premium', 'price' => 34.99, 'old_price' => 45, 'image' => '🧘', 'badge' => 'Deal', 'description' => 'Non-slip, extra thick. Easy to clean and carry.', 'category' => 'sports', 'is_new' => false, 'on_sale' => true],
            ['name' => 'Desk Lamp LED', 'slug' => 'desk-lamp-led', 'price' => 59.99, 'old_price' => 79, 'image' => '💡', 'description' => 'Adjustable brightness, USB port. Eye-care technology.', 'category' => 'home-garden', 'is_new' => false, 'on_sale' => true],
            ['name' => 'Skincare Set', 'slug' => 'skincare-set', 'price' => 44.99, 'image' => '🧴', 'description' => 'Cleanser, serum, moisturizer. Gentle for all skin types.', 'category' => 'beauty', 'is_new' => true, 'on_sale' => false],
            ['name' => 'Classic Novel Collection', 'slug' => 'classic-novel-collection', 'price' => 19.99, 'old_price' => 29, 'image' => '📚', 'description' => 'Set of 3 bestselling novels. Paperback edition.', 'category' => 'books', 'is_new' => false, 'on_sale' => true],
        ];

        foreach ($products as $p) {
            $category = Category::where('slug', $p['category'])->first();
            if (!$category) continue;

            $slug = $p['slug'];
            unset($p['category']);

            Product::updateOrCreate(
                ['slug' => $slug],
                [
                    'category_id' => $category->id,
                    'name' => $p['name'],
                    'slug' => $slug,
                    'description' => $p['description'] ?? null,
                    'price' => $p['price'],
                    'old_price' => $p['old_price'] ?? null,
                    'image' => $p['image'] ?? null,
                    'badge' => $p['badge'] ?? null,
                    'is_new' => $p['is_new'] ?? false,
                    'on_sale' => $p['on_sale'] ?? false,
                    'stock' => 100,
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Electronics', 'slug' => 'electronics', 'color' => 'bg-blue-100 text-blue-700', 'sort_order' => 1],
            ['name' => 'Fashion', 'slug' => 'fashion', 'color' => 'bg-pink-100 text-pink-700', 'sort_order' => 2],
            ['name' => 'Home & Garden', 'slug' => 'home-garden', 'color' => 'bg-green-100 text-green-700', 'sort_order' => 3],
            ['name' => 'Sports', 'slug' => 'sports', 'color' => 'bg-amber-100 text-amber-700', 'sort_order' => 4],
            ['name' => 'Books', 'slug' => 'books', 'color' => 'bg-purple-100 text-purple-700', 'sort_order' => 5],
            ['name' => 'Beauty', 'slug' => 'beauty', 'color' => 'bg-rose-100 text-rose-700', 'sort_order' => 6],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }
    }
}

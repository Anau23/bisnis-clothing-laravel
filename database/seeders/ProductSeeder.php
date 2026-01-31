<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Basic White T-Shirt',
            'description' => 'Kaos putih basic',
            'price' => 75000,
            'category' => 'T-Shirt',
            'stock' => 50,
            'size' => 'M',
            'color' => 'White',
            'image_url' => null,
        ]);

        Product::create([
            'name' => 'Black Hoodie',
            'description' => 'Hoodie hitam nyaman',
            'price' => 185000,
            'category' => 'Hoodie',
            'stock' => 20,
            'size' => 'L',
            'color' => 'Black',
            'image_url' => null,
        ]);
    }
}

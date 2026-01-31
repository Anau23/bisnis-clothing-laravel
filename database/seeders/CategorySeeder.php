<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'T-Shirt', 'description' => 'Kaos pria & wanita'],
            ['name' => 'Hoodie', 'description' => 'Hoodie & sweater'],
            ['name' => 'Pants', 'description' => 'Celana casual'],
        ];

        foreach ($categories as $cat) {
            Category::create($cat);
        }
    }
}

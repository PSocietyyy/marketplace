<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Fashion',
            'Elektronik',
            'Baju',
            'Celana',
            'Laptop',
            'Sepatu',
            'Aksesoris',
            'Tas',
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(
                ['name' => $category],
                ['created_at' => now()]
            );
        }
    }
}

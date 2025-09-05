<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Umkn;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $umkn = Umkn::where('umkn_name', 'Sepatu Mantap Jaya')->first();
        $category = Category::where('name', 'Sepatu')->first();

        if ($umkn && $category) {
            Product::firstOrCreate(
                [
                    'umkn_id'     => $umkn->id,
                    'product_name'=> 'Sepatu Keren Sport',
                ],
                [
                    'description' => 'Sepatu sport nyaman dipakai untuk olahraga maupun sehari-hari.',
                    'price'       => 350000,
                    'stock'       => 20,
                    'image'       => 'https://images.unsplash.com/photo-1543508282-6319a3e2621f?q=80&w=415&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                    'category_id' => $category->id,
                ]
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductImagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::all()->each(function ($product) {
            ProductImages::factory(1)->create([
                'product_id' => $product->id,
            ]);
        });
    }
}

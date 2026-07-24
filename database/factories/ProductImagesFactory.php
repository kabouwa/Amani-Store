<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\ProductImages;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ProductImages>
 */
class ProductImagesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'image' => null,
            'is_primary' => 1,
        ];
    }
}

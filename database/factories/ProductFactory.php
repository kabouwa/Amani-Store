<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);
        return [
            'category_id' => Category::inRandomOrder()->first()->id,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->realText(400),
            'stock' => fake()->numberBetween(0,100),
            'purchase_price' => fake()->numberBetween(0,100),
            'selling_price' => fake()->numberBetween(100,250),
            'is_active' => fake()->boolean(),
        ];
    }
}

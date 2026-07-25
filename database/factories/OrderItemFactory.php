<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\Model;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Model>
 */
class OrderItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $product = Product::inRandomOrder()->first();
        return [
            'product_id' => $product->id,
            'purchase_price' => $product->purchase_price,
            'selling_price' => $product->selling_price,
            'quantity' => random_int(1, $product->stock),
        ];
    }
}

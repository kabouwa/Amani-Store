<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        do {
            $code = 'AMN-' . now()->format('ym') . '-' . random_int(100000, 999999);
        } while (Order::where('code', $code)->exists());

        return [
            'code' => $code,
            'shipping_price' => 35,
            'total_price' => 35 + random_int(80,400),
            'shipping_agency' => 'Sendit',
            'note' => fake()->paragraph(5)
        ];
    }
}

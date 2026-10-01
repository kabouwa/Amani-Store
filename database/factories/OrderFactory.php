<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;
use Nette\Utils\Random;
use Random\Randomizer;

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

        $status = ['PENDING','PREPARING','TOPICKUP','PICKEDUP','DELIVERING','DELIVERED','CANCELED'];
        collect($status)->random();
        
        return [
            'code' => $code,
            'shipping_price' => 35,
            'total_price' => 9999,
            'shipping_agency' => 'Sendit',
            'status' => $status[array_rand($status)],
            'note' => fake()->paragraph(2)
        ];
    }
}

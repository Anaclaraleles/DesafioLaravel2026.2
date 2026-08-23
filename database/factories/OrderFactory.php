<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Str;
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
    
        /**
         * Depois de criar o item, garante que o vendedor nunca seja
         * o mesmo usuário que comprou (buyer_id do pedido relacionado).
         */

    public function definition(): array
    {
        return [
            'buyer_id' => fake()->randomElement([2, 3]),
            'total' => fake()->randomFloat(2, 20, 500),
            'status' => 'paid',
            'reference_id' => Str::uuid(),
            'created_at' => fake()->dateTimeBetween('-12 months', 'now'),
        ];
    }
}

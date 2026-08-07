<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement([
                'Celular', 'Bateria', 'Caixa de som', 'Fone de ouvido',
            ]),
            'price' => fake()->randomFloat(2, 10, 1000),
            'quantity' => fake()->numberBetween(0, 100),
            'photo' => fake()->imageUrl(640, 480, 'products', true),
        ];
    }
}

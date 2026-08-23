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
            'user_id' => fake()->randomElement([2, 3]),
            'name' => fake()->words(3, true),
            'description' => fake()->paragraph(),
            'category' => fake()->randomElement([
                'Celular', 'Bateria', 'Caixa de som', 'Fone de ouvido',
            ]),
            'price' => fake()->randomFloat(2, 10, 1000),
            'quantity' => fake()->numberBetween(0, 100),
            'photo' => 'images/' . fake()->randomElement([
                            'Produto1.webp',
                            'Produto2.webp',
                            'Produto3.webp',
                            'Produto4.webp',
                            'Produto5.webp',
                        ]),
            'created_at' => fake()->dateTimeBetween('-12 months', 'now'),
        ];
    }
}

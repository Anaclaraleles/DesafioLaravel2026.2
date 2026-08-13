<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cep' => $this->faker->numerify('########'),
            'street' => $this->faker->streetName(),
            'number' => $this->faker->buildingNumber(), 
            'neighborhood' => $this->faker->word(),
            'city' => $this->faker->city(),
            'state' => strtoupper($this->faker->lexify('??')),
            'complement' => $this->faker->optional()->secondaryAddress(),
            'user_id' => User::factory(),
        ];
    }
}

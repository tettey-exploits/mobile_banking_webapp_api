<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "first_name" => $this->faker->firstName(),
            "last_name" => $this->faker->lastName(),
            "age" => $this->faker->numberBetween(18, 120),
            "contact" => $this->faker->randomNumber(9),
            "location" => $this->faker->streetAddress(),
            "username" => $this->faker->userName(),
            "email" => $this->faker->email(),
            "password" => $this->faker->password
        ];
    }
}

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
            "date_of_birth" => $this->faker->date( max: now()),
            "contact" => $this->faker->randomNumber(9),
            "account_number" => date("dmy") . $this->faker->randomNumber(6),
            "location" => $this->faker->streetAddress(),
            "username" => $this->faker->userName(),
            "email" => $this->faker->email(),
            "password" => $this->faker->password,
            "created_at" => now(),
            "updated_at" => now()
        ];
    }
}

<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Permission>
 */
class PermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            ["permission" => "collect summary"],
            ["permission" => "manage account details"],
            ["permission" => "access all teller activities"],
            ["permission" => "take deposits"],
            ["permission" => "view deposits"],
            ["permission" => "access customers profiles"],
            ["permission" => "view customer profile"],
            ["permission" => "add new customer"]
        ];
    }
}

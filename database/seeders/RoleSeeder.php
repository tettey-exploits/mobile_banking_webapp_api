<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Role::insert([
            ["role" => "admin"],
            ["role" => "manager"],
            ["role" => "teller"],
            ["role" => "customer"],
            ["role" => "collector"]
        ]);
    }
}

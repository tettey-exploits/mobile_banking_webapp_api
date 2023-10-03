<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Permission::insert([
            ["permission" => "collect summary"],
            ["permission" => "manage account details"],
            ["permission" => "access all teller activities"],
            ["permission" => "take deposits"],
            ["permission" => "view deposits"],
            ["permission" => "access customers profiles"],
            ["permission" => "view customer profile"],
            ["permission" => "add new customer"]
        ]);
    }
}

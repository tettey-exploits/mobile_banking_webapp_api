<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        Permission::insert([
            ["permission"=>"collect summary"],
            ["permission"=>"manage account details"],
            ["permission"=>"access all teller activities"],
            ["permission"=>"take deposits"],
            ["permission"=>"view deposits"],
            ["permission"=>"access customers profiles"],
            ["permission"=>"view customer profile"],
            ["permission"=>"add new customer"]
        ]);
    }
}

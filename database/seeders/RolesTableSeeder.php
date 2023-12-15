<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name' => 'user', 'description' => 'Regular User.'],
            ['name' => 'admin', 'description' => 'Owner of Garage.'],
            ['name' => 'superadmin', 'description' => 'Owner of the system.'],
        ]);
    }
}

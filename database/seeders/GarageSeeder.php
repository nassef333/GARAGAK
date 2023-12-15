<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GarageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 20; $i++) {
            DB::table('garages')->insert([
                'name' => 'Garage ' . $i,
                'location' => 'Location ' . $i,
                'governate' => 'Governate ' . $i,
                'number_of_slots' => rand(50, 100),
                'available_slots' => rand(10, 50),
                'rate' => rand(10, 50) / 10, // Generating a decimal rate between 1.0 and 5.0
                'no_reviews' => rand(1, 100),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Assuming garage IDs start from 1
        for ($garageId = 1; $garageId <= 20; $garageId++) {
            for ($i = 1; $i <= 5; $i++) {
                DB::table('prices')->insert([
                    'garage_id' => $garageId,
                    'no_hours' => $i,
                    'hour_price' => rand(5, 15),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

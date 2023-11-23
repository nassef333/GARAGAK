<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SlotsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($garageId = 1; $garageId <= 20; $garageId++) {
            for ($slotNumber = 1; $slotNumber <= 50; $slotNumber++) {
                $currentCarId = rand(1, 100) <= 80 ? rand(1, 1000) : null;

                DB::table('slots')->insert([
                    'garage_id' => $garageId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}

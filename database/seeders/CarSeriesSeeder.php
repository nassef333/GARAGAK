<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CarSeriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $carSeriesData = [
            [
                'brand' => 'BMW',
                'series' => ['1 Series', '2 Series', '3 Series', '4 Series', '5 Series'],
            ],
            [
                'brand' => 'Mercedes-Benz',
                'series' => ['A-Class', 'C-Class', 'E-Class', 'S-Class', 'G-Class'],
            ],
            [
                'brand' => 'Audi',
                'series' => ['A3', 'A4', 'A6', 'Q5', 'Q7'],
            ],
            [
                'brand' => 'Toyota',
                'series' => ['Camry', 'Corolla', 'Rav4', 'Highlander', 'Tacoma'],
            ],
            [
                'brand' => 'Honda',
                'series' => ['Civic', 'Accord', 'Pilot', 'CR-V', 'Odyssey'],
            ],
            [
                'brand' => 'Ford',
                'series' => ['Fusion', 'Escape', 'Explorer', 'F-150', 'Mustang'],
            ],
            [
                'brand' => 'Chevrolet',
                'series' => ['Malibu', 'Equinox', 'Traverse', 'Silverado', 'Camaro'],
            ],
            [
                'brand' => 'Nissan',
                'series' => ['Altima', 'Rogue', 'Pathfinder', 'Titan', '370Z'],
            ],
            [
                'brand' => 'Tesla',
                'series' => ['Model S', 'Model 3', 'Model X', 'Model Y'],
            ],
            [
                'brand' => 'Lexus',
                'series' => ['ES', 'RX', 'IS', 'NX', 'GX'],
            ],
        ];

        foreach ($carSeriesData as $brandData) {
            $brandId = DB::table('brands')->where('name', $brandData['brand'])->value('id');

            foreach ($brandData['series'] as $seriesName) {
                DB::table('car_series')->insert([
                    'name' => $seriesName,
                    'brand_id' => $brandId,
                ]);
            }
        }
    }
}

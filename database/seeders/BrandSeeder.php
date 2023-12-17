<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $brands = [];

        $carBrands = [
            'BMW', 'Mercedes-Benz', 'Audi', 'Toyota', 'Honda',
            'Ford', 'Chevrolet', 'Nissan', 'Tesla', 'Lexus',
        ];

        $countries = [
            'Germany', 'United States', 'Japan', 'South Korea', 'United Kingdom',
            'Italy', 'France', 'Sweden', 'China', 'Canada',
        ];

        foreach ($carBrands as $key => $brand) {
            $brands[] = [
                'name' => $brand,
                'origin' => $countries[$key],
            ];
        }

        DB::table('brands')->insert($brands);
    }
}

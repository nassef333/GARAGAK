<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();
        $coupons = [];

        for ($i = 0; $i < 10; $i++) {
            $coupons[] = [
                'value' => $faker->numberBetween(5, 50),
                'code' => $faker->unique()->regexify('[A-Z0-9]{10}'),
                'is_enabled' => $faker->boolean,
                'count' => $faker->numberBetween(50, 200),
                'limit_price' => $faker->randomFloat(2, 20, 100),
                'description' => $faker->sentence,
                'expires_at' => $faker->dateTimeBetween('now', '+1 year'),
            ];
        }

        DB::table('coupons')->insert($coupons);
    }
}

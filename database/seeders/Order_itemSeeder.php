<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Order_itemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            $faker = \Faker\Factory::create();
            DB::table("order_items")->insert([
                "order_id" => $faker->numberBetween(1, 30),
                "product_id" => $faker->numberBetween(1, 3),
                "product_name" => $faker->name(),
                "quantily" => rand(1, 3),
                "price" => rand(10000000, 999999999),
            ]);
        };
    }
}

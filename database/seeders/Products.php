<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Products extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 30; $i++){
            $faker = \Faker\Factory::create();
            DB::table("products")->insert([
                "name" => $faker->name(),
                "slug" => Str::slug($faker->name(),'-'),
                "price" => $faker->numberBetween($min = 1500, $max = 6000),
                "quantity" => $faker->numberBetween($min = 10, $max = 1000),
                "content" => $faker->word,
                "thumb" => 'no-images.jpg',
                "image" => 'no-images.jpg',
                'status' => $faker->numberBetween(0, 1),
                "user_id" => $faker->numberBetween(1, 2),
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),

            ]);
        };
    }
}

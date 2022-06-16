<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SliderSeeder extends Seeder
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
            DB::table("sliders")->insert([
                "name" => $faker->name(),
                "location" => $faker->numberBetween(1, 3),
                "link_target" => $faker->word,
                "image" => 'no-images.jpg',
                'position' => $faker->numberBetween(1, 3),
                'status' => $faker->numberBetween(0, 1),
                "user_id" => $faker->numberBetween(1, 2),
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        };
    }
}

<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class categories extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       for($i = 0; $i < 11; $i++){
        $faker = \Faker\Factory::create();
        DB::table("categories")->insert([
            "name" => $faker->unique()->name(),
            "slug" => $faker->unique()->name(),
            "taxonomy" => $faker->numberBetween(0, 1),
            "parent_id" => $faker->numberBetween(0, 3),
            "user_id" => $faker->numberBetween(1, 100),
            "status" => '1',
            ]);
        };
    }
}

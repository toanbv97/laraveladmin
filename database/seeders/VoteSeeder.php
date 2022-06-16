<?php

namespace Database\Seeders;

use App\Models\Vote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class VoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i = 0; $i < 20; $i++){
            $faker = \Faker\Factory::create();
            DB::table("votes")->insert([
                "name_user" => $faker->name(),
                "level" => $faker->numberBetween(1, 3),
                "comment" => $faker->word,
                "product_id" => $faker->numberBetween(1, 5),
                "user_id" => $faker->numberBetween(1, 2),
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        };

        for($i = 21; $i < 40; $i++){
            $faker = \Faker\Factory::create();
            DB::table("votes")->insert([
                "name_user" => $faker->name(),
                "level" => $faker->numberBetween(1, 3),
                "comment" => $faker->word,
                "post_id" => $faker->numberBetween(1, 5),
                "user_id" => $faker->numberBetween(1, 2),
                "created_at" => Carbon::now()->format('Y-m-d H:i:s'),
                "updated_at" => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        };
    }
}

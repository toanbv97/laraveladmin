<?php

namespace Database\Seeders;

use Faker\Core\Number;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 30; $i++) {
            $faker = \Faker\Factory::create();
            DB::table("orders")->insert([
                "customer_id" => $faker->numberBetween(1, 30),
                "customer_name" => $faker->name(),
                'email' => Str::random(10).'@gmail.com',
                "address" => $faker->address(),
                "phone_number" => '0'.rand(700000000, 999999999),
                "note" => $faker->name(),
                "payment_method" => 'Thanh toán khi nhận hàng',
                "total" => rand(10000000, 999999999),
                "status" => rand(1, 5),
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        };
    }
}

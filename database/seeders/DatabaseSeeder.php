<?php

namespace Database\Seeders;

use App\Models\Order_item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call([
            PermissionSeeder::class,
        ]);
        $this->call([
            UserSeeder::class,
        ]);
        $this->call([
            PostSeeder::class,
        ]);

        $this->call([
            SliderSeeder::class
        ]);

        $this->call([
            categories::class,
            Permission::class,
            Products::class,
            CustomerSeeder::class,
            OrderSeeder::class,
            Order_itemSeeder::class,
        ]);
        $this->call([
            VoteSeeder::class,
        ]);
    }
}

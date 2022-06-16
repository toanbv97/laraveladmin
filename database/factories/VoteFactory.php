<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'level' => 2,
            'comment' =>$this->faker->unique()->sentence(),
            'name_user' => $this->faker->name(),
            'post_id' => $this->faker->numberBetween(1,10),
            'user_id'=>$this->faker->numberBetween(1,2),
        ];
    }
}

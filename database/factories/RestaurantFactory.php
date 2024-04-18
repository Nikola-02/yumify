<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'=>$this->faker->company(),
            'description'=>fake()->text('139'),
            'location'=>fake()->text('15'),
            'open_in'=>fake()->time(),
            'close_in'=>fake()->time(),
            'image'=>'mc.png',
        ];
    }
}

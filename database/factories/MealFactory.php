<?php

namespace Database\Factories;

use App\Models\Type;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meal>
 */
class MealFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $all_types = Type::all()->pluck('id')->ToArray();

        return [
            'name'=>fake()->name,
            'description'=>fake()->text(70),
            'image'=>'cookie.jpg',
            'type_id'=>$all_types[array_rand($all_types)]
        ];
    }
}

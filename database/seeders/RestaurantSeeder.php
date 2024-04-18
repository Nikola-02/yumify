<?php

namespace Database\Seeders;

use App\Models\Benefit;
use App\Models\Meal;
use App\Models\Price;
use App\Models\Restaurant;
use App\Models\Role;
use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = Type::all();
        $benefits = Benefit::all();

        for ($i = 0; $i < 10; $i++) {
            $restaurant = Restaurant::factory()
                ->has(Meal::factory(10)->has(Price::factory()))
                ->create();

            $restaurant->types()->attach($types->random(2));
            $restaurant->benefits()->attach($benefits->random(2));
        }



    }
}

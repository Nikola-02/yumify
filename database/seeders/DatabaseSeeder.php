<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use Database\Factories\TypeFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(
            [
                RoleSeeder::class,
                UserSeeder::class,
                TypeSeeder::class,
                BenefitSeeder::class,
                RestaurantSeeder::class
            ]
        );
    }
}
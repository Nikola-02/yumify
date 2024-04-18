<?php

namespace Database\Seeders;

use App\Models\Benefit;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Benefit::create([
            'name'=>'WC'
        ]);

        Benefit::create([
            'name'=>'Parking'
        ]);

        Benefit::create([
            'name'=>'WIFI'
        ]);

        Benefit::create([
            'name'=>'Spa'
        ]);

        Benefit::create([
            'name'=>'Gym'
        ]);
    }
}

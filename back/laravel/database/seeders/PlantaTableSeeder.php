<?php

namespace Database\Seeders;

use App\Models\Planta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlantaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Planta::updateOrCreate(['name' => 'Zona exterior']);
        Planta::updateOrCreate(['name' => 'Planta 0']);
        Planta::updateOrCreate(['name' => 'Planta 1']);
        Planta::updateOrCreate(['name' => 'Planta 2']);
        Planta::updateOrCreate(['name' => 'Planta 3']);
    }
}

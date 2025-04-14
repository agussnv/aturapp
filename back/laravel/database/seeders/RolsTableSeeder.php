<?php

namespace Database\Seeders;

use App\Models\Rol;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Rol::updateOrCreate(['name' => 'Alumne']);
        Rol::updateOrCreate(['name' => 'Coordinador']);
        Rol::updateOrCreate(['name' => 'Professor']);
    }
}
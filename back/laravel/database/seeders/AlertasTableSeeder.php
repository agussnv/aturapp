<?php

namespace Database\Seeders;

use App\Models\Alerta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AlertasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Alerta::updateOrCreate(['alumno_id' => 1, 'sector_id' => 1, 'descripcion' => 'test1', 'estado_id' => 1]);
        Alerta::updateOrCreate(['alumno_id' => 2, 'sector_id' => 2, 'descripcion' => 'test2', 'estado_id' => 2]);
        Alerta::updateOrCreate(['alumno_id' => 3, 'sector_id' => 3, 'descripcion' => 'test3', 'estado_id' => 3]);
        
        Alerta::updateOrCreate(['alumno_id' => 1, 'sector_id' => 1, 'estado_id' => 1]);
        Alerta::updateOrCreate(['alumno_id' => 2, 'sector_id' => 2, 'estado_id' => 2]);
        Alerta::updateOrCreate(['alumno_id' => 3, 'sector_id' => 3, 'estado_id' => 3]);
    }
}

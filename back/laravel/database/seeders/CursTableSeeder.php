<?php

namespace Database\Seeders;

use App\Models\Curs;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CursTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Curs::updateOrCreate(['name' => '1DAW']);
        Curs::updateOrCreate(['name' => '2DAW']);
        Curs::updateOrCreate(['name' => '1DAM']);
        Curs::updateOrCreate(['name' => '2DAM']);
        Curs::updateOrCreate(['name' => '1ASIX']);
        Curs::updateOrCreate(['name' => '2ASIX']);
    }
}

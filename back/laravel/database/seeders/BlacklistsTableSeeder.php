<?php

namespace Database\Seeders;

use App\Models\Blacklist;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BlacklistsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Blacklist::updateOrCreate(['email' => 'a23agunovnov@inspedralbes.cat']);
    }
}

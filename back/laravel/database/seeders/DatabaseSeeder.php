<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolsTableSeeder::class);
        $this->call(CursTableSeeder::class);
        $this->call(TornsTableSeeder::class);
        // $this->call(BlacklistsTableSeeder::class);
        $this->call(PlantaTableSeeder::class);
        $this->call(SectorsTableSeeder::class);
        $this->call(PreguntaTableSeeder::class);

        User::updateOrCreate([
            'nom' => 'Agustín Enzo',
            'cognoms' => 'Noviello',
            'dni' => 'Z0000000M',
            'email' => 'a23agunovnov@inspedralbes.cat',
            'email_verified_at' => '11/12/2024',
            'password' => '123456',
            'rol' => 1,
            'curs' => 1,
            'torn' => 1
        ]);
        User::updateOrCreate([
            'nom' => 'Marc',
            'cognoms' => 'Ciurans',
            'dni' => '12345678J',
            'email' => 'a23marciucar@inspedralbes.cat',
            'email_verified_at' => '11/12/2024',
            'password' => '123456',
            'rol' => 2,
            'curs' => 1,
            'torn' => 2
        ]);
        User::updateOrCreate([
            'nom' => 'Benjamin',
            'cognoms' => 'Romero',
            'dni' => '12345678X',
            'email' => 'a23benromdor@inspedralbes.cat',
            'email_verified_at' => '11/12/2024',
            'password' => '123456',
            'rol' => 2,
            'curs' => 1,
            'torn' => 1
        ]);
        User::updateOrCreate([
            'nom' => 'Arnau',
            'cognoms' => 'Barrero',
            'dni' => '47748680J',
            'email' => 'a23arnbarsor@inspedralbes.cat',
            'email_verified_at' => '11/12/2024',
            'password' => 'Arnau_2004',
            'rol' => 2,
            'curs' => 1,
            'torn' => 1
        ]);

        // $this->call(MessagesTableSeeder::class);
        $this->call(EstadosTableSeeder::class);
        $this->call(AlertasTableSeeder::class);
    }
}

<?php
    namespace Database\Seeders;

    use App\Models\Pregunta;
    use Illuminate\Database\Seeder;
    use Illuminate\Support\Facades\DB; 
    use Illuminate\Support\Str;

    class PreguntaTableSeeder extends Seeder
    {
        /**
         * Run the database seeds.
         */
        public function run(): void
        {
            DB::table('preguntas')->insert([
                ['pregunta' => 'Em cau bé?',   'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'No em cau bé?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'Fa córrer rumors?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'Ajuda als altres?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'Dóna empentes?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'No deixa participar?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'Anima els altres?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'Insulta?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'A qui donen empentes?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'A qui insulten i ridiculitzen?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'A qui no deixen participar?', 'created_at' => now(), 'updated_at' => now()],
                ['pregunta' => 'Qui són els teus amics/amigues?', 'created_at' => now(), 'updated_at' => now()],
            ]);
        }
    }
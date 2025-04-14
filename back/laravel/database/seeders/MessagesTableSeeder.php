<?php

namespace Database\Seeders;

use App\Models\Message;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MessagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Message::updateOrCreate(['sender_id' => 1, 'receiver_id' => 3, 'message' => 'MessageAlumne #1']);
        Message::updateOrCreate(['sender_id' => 2, 'receiver_id' => 3, 'message' => 'MessageAlumne #2']);
        Message::updateOrCreate(['sender_id' => 3, 'receiver_id' => 1, 'message' => 'MessageCoordinador #1']);
        Message::updateOrCreate(['sender_id' => 3, 'receiver_id' => 2, 'message' => 'MessageCoordinador #2']);
    }
}

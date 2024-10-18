<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TimeSlotSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('time_slots')->insert([
            ['slot' => 'Ca 1', 'start_time' => '07:30:00', 'end_time' => '09:00:00'],
            ['slot' => 'Ca 2', 'start_time' => '09:10:00', 'end_time' => '10:40:00'],
            ['slot' => 'Ca 3', 'start_time' => '10:50:00', 'end_time' => '12:20:00'],
            ['slot' => 'Ca 4', 'start_time' => '13:30:00', 'end_time' => '15:00:00'],
            ['slot' => 'Ca 5', 'start_time' => '15:10:00', 'end_time' => '16:40:00'],
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('semesters')->insert([
            [
                'block' => 'Fall',
                'year' => 2024,
                'start_date' => '2024-08-15',
                'end_date' => '2024-12-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'block' => 'Spring',
                'year' => 2025,
                'start_date' => '2025-01-15',
                'end_date' => '2025-05-30',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
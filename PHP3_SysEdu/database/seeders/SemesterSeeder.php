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
                'block' => 'Spring',
                'year' => 2024,
                'start_date' => '2024-01-15',
                'end_date' => '2024-05-30',
            ],
            [
                'block' => 'Fall',
                'year' => 2024,
                'start_date' => '2024-08-15',
                'end_date' => '2024-12-30',
            ],
        ]);
    }
}
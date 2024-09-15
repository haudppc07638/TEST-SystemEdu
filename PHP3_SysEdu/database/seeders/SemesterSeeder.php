<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SemesterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('semesters')->insert([
            ['id' => 1, 'block' => 'K01', 'year' => '2024-01-01'],
            ['id' => 2, 'block' => 'K01', 'year' => '2024-07-01'],
            ['id' => 3, 'block' => 'K02', 'year' => '2024-01-01'],
            ['id' => 4, 'block' => 'K02', 'year' => '2024-07-01'],
            ['id' => 5, 'block' => 'K03', 'year' => '2025-01-01'],
            ['id' => 6, 'block' => 'K03', 'year' => '2025-07-01'],
            ['id' => 7, 'block' => 'K04', 'year' => '2025-01-01'],
            ['id' => 8, 'block' => 'K04', 'year' => '2025-07-01'],
            ['id' => 9, 'block' => 'K05', 'year' => '2026-01-01'],
            ['id' => 10, 'block' => 'K05', 'year' => '2026-07-01'],
        ]);
    }
}

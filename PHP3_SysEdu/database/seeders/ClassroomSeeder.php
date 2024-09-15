<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class ClassroomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('classrooms')->insert([
            ['id' => 1, 'code' => 'WW001'],
            ['id' => 2, 'code' => 'WW002'],
            ['id' => 3, 'code' => 'WW003'],
            ['id' => 4, 'code' => 'WW004'],
            ['id' => 5, 'code' => 'WW005'],
            ['id' => 6, 'code' => 'WW006'],
            ['id' => 7, 'code' => 'WW007'],
            ['id' => 8, 'code' => 'WW008'],
            ['id' => 9, 'code' => 'WW009'],
        ]);
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('classrooms')->insert([
            ['code' => 'A101', 'capacity' => 40],
            ['code' => 'A102', 'capacity' => 40],
            ['code' => 'B201', 'capacity' => 40],
            ['code' => 'B202', 'capacity' => 40],
            ['code' => 'C301', 'capacity' => 40],
        ]);
    }
}
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClassroomSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('classrooms')->insert([
            ['code' => 'A101'],
            ['code' => 'A102'],
            ['code' => 'B201'],
            ['code' => 'B202'],
            ['code' => 'C301'],
        ]);
    }
}
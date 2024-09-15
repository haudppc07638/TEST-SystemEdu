<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('students')->insert([
            'id' => 6,
            'fullname' => 'Lộc Kar',
            'code' => 'PC03',
            'email' => 'loctvpc06110@fpt.edu.vn',
            'password' => Hash::make('abc1234'),
            'phone' => '0828581112',
            'image' => 'abc123.jpg',
            'major_id' => 2,
            'class_id' => 1,
        ]);
    }
}

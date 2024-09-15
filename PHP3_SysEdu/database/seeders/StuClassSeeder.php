<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StuClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         DB::table('classes')->insert([
            'id' => 1,
            'name' => 'F301',
            'quantity' => 12,
            'trainingsystem' => 'Hệ 1',
            'major_id' => 1,
        ]);
    }
}

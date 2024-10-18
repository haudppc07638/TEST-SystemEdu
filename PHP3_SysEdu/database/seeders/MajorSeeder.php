<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('majors')->insert([
            [
                'name' => 'Ứng dụng phần mềm',
                'code' => 'UDPM',
                'total_credits' => 93,
                'faculty_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Quản trị mạng máy tính',
                'code' => 'QTMMT',
                'total_credits' => 106,
                'faculty_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Chế biến thực phẩm',
                'code' => 'CBTP',
                'total_credits' => 100,
                'faculty_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Công nghệ ô tô',
                'code' => 'CNOT',
                'total_credits' => 98,
                'faculty_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
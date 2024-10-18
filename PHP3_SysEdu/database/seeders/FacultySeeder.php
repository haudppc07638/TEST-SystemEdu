<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('faculties')->insert([
            [
                'name' => 'Công nghệ Thông tin',
                'code' => 'CNTT',
                'dean' => null,
                'assistant_dean' => null,
                'description' => 'Khoa chuyên đào tạo về công nghệ thông tin.'
            ],
            [
                'name' => 'Công nghệ thực phẩm',
                'code' => 'CNTP',
                'dean' => null,
                'assistant_dean' => null,
                'description' => 'Khoa chuyên đào tạo về công nghệ thực phẩm.'
            ],
            [
                'name' => 'Khoa cơ khí ô tô',
                'code' => 'CKOT',
                'dean' => null,
                'assistant_dean' => null,
                'description' => 'Khoa chuyên đào tạo về cơ khí ô tô.'
            ]
        ]);
    }
}
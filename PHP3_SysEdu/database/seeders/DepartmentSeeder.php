<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('departments')->insert([
            [
                'name' => 'Dịch vụ sinh viên',
                'location' => 'Tầng 1, Nhà A'
            ],
            [
                'name' => 'Quan hệ doanh nghiệp',
                'location' => 'Tầng 2, Nhà B'
            ],
            [
                'name' => 'Giáo vụ Đào tạo',
                'location' => 'Tầng 3, Nhà C'
            ],
            [
                'name' => 'Hành chính – Kế toán',
                'location' => 'Tầng 4, Nhà D'
            ],
            [
                'name' => 'Công tác sinh viên',
                'location' => 'Tầng 5, Nhà E'
            ],
        ]);
    }
}
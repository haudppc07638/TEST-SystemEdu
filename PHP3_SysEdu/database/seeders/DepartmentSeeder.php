<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('departments')->insert([
            ['name' => 'Phòng Tài Chính', 'location' => 'Tầng 1, Tòa nhà A'],
            ['name' => 'Phòng Nhân Sự', 'location' => 'Tầng 2, Tòa nhà B'],
            ['name' => 'Phòng Kế Hoạch', 'location' => 'Tầng 3, Tòa nhà C'],
            ['name' => 'Phòng Công Nghệ Thông Tin', 'location' => 'Tầng 4, Tòa nhà D'],
            ['name' => 'Phòng Marketing', 'location' => 'Tầng 5, Tòa nhà E'],
            ['name' => 'Phòng Hành Chính', 'location' => 'Tầng 1, Tòa nhà F'],
            ['name' => 'Phòng Dự Án', 'location' => 'Tầng 2, Tòa nhà G'],
            ['name' => 'Phòng Sản Xuất', 'location' => 'Tầng 3, Tòa nhà H'],
            ['name' => 'Phòng Bán Hàng', 'location' => 'Tầng 4, Tòa nhà I'],
            ['name' => 'Phòng Pháp Lý', 'location' => 'Tầng 5, Tòa nhà J'],
        ]);
    }
}

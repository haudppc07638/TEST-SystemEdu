<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $majors = [
            ['id' => 1, 'name' => 'Công Nghệ Thông Tin', 'faculty_id' => 1],
            ['id' => 2, 'name' => 'Kinh Tế Đầu Tư', 'faculty_id' => 2],
            ['id' => 3, 'name' => 'Y Học', 'faculty_id' => 3],
            ['id' => 4, 'name' => 'Xã Hội Học', 'faculty_id' => 4],
            ['id' => 5, 'name' => 'Hóa Học Ứng Dụng', 'faculty_id' => 5],
            ['id' => 6, 'name' => 'Sinh Học Ứng Dụng', 'faculty_id' => 6],
            ['id' => 7, 'name' => 'Vật Lý Ứng Dụng', 'faculty_id' => 7],
            ['id' => 8, 'name' => 'Toán Học Tài Chính', 'faculty_id' => 8],
            ['id' => 9, 'name' => 'Cơ Điện Tử', 'faculty_id' => 9],
            ['id' => 10, 'name' => 'Quản Trị Kinh Doanh Quốc Tế', 'faculty_id' => 10],
            ['id' => 11, 'name' => 'Mạng Máy Tính', 'faculty_id' => 1],
            ['id' => 12, 'name' => 'Kinh Tế Quản Lý', 'faculty_id' => 2],
            ['id' => 13, 'name' => 'Dược Học', 'faculty_id' => 3],
            ['id' => 14, 'name' => 'Nhân Văn', 'faculty_id' => 4],
            ['id' => 15, 'name' => 'Phân Tích Hóa Học', 'faculty_id' => 5],
            ['id' => 16, 'name' => 'Sinh Học Phân Tử', 'faculty_id' => 6],
            ['id' => 17, 'name' => 'Vật Lý Kỹ Thuật', 'faculty_id' => 7],
            ['id' => 18, 'name' => 'Toán Học Ứng Dụng', 'faculty_id' => 8],
            ['id' => 19, 'name' => 'Điện Tử Viễn Thông', 'faculty_id' => 9],
            ['id' => 20, 'name' => 'Quản Trị Doanh Nghiệp', 'faculty_id' => 10],
            ['id' => 21, 'name' => 'Thiết Kế Phần Mềm', 'faculty_id' => 1],
            ['id' => 22, 'name' => 'Kinh Tế Phát Triển', 'faculty_id' => 2],
            ['id' => 23, 'name' => 'Y Sinh Học', 'faculty_id' => 3],
            ['id' => 24, 'name' => 'Xã Hội và Văn Hóa', 'faculty_id' => 4],
            ['id' => 25, 'name' => 'Hóa Sinh', 'faculty_id' => 5],
            ['id' => 26, 'name' => 'Sinh Học Marine', 'faculty_id' => 6],
            ['id' => 27, 'name' => 'Vật Lý Toán', 'faculty_id' => 7],
            ['id' => 28, 'name' => 'Toán và Tin Học', 'faculty_id' => 8],
            ['id' => 29, 'name' => 'Kỹ Thuật Điện', 'faculty_id' => 9],
            ['id' => 30, 'name' => 'Kinh Doanh Quốc Tế', 'faculty_id' => 10],
        ];

        DB::table('majors')->insert($majors);
    }
}

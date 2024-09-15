<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subjects')->insert([
            // Các môn học cho chuyên ngành Công Nghệ Thông Tin
            ['code' => 'SUBJ001', 'name' => 'Nhập Môn Công Nghệ Thông Tin', 'description' => 'Giới thiệu về CNTT', 'major_id' => 1],
            ['code' => 'SUBJ002', 'name' => 'Lập Trình Cơ Bản', 'description' => 'Cơ sở lập trình', 'major_id' => 1],
            ['code' => 'SUBJ003', 'name' => 'Cấu Trúc Dữ Liệu', 'description' => 'Các cấu trúc dữ liệu cơ bản', 'major_id' => 1],

            // Các môn học cho chuyên ngành Kinh Tế Đầu Tư
            ['code' => 'SUBJ004', 'name' => 'Nguyên Lý Kinh Tế', 'description' => 'Các nguyên lý cơ bản của kinh tế', 'major_id' => 2],
            ['code' => 'SUBJ005', 'name' => 'Quản Trị Đầu Tư', 'description' => 'Quản lý các dự án đầu tư', 'major_id' => 2],
            ['code' => 'SUBJ006', 'name' => 'Kinh Tế Học', 'description' => 'Các khái niệm kinh tế cơ bản', 'major_id' => 2],

            // Các môn học cho chuyên ngành Y Học
            ['code' => 'SUBJ007', 'name' => 'Giải Phẫu Học', 'description' => 'Cấu trúc cơ thể người', 'major_id' => 3],
            ['code' => 'SUBJ008', 'name' => 'Sinh Lý Học', 'description' => 'Chức năng của các hệ cơ quan', 'major_id' => 3],
            ['code' => 'SUBJ009', 'name' => 'Dược Lý', 'description' => 'Các loại thuốc và tác dụng của chúng', 'major_id' => 3],

            // Các môn học cho chuyên ngành Xã Hội Học
            ['code' => 'SUBJ010', 'name' => 'Nhập Môn Xã Hội Học', 'description' => 'Khái quát về xã hội học', 'major_id' => 4],
            ['code' => 'SUBJ011', 'name' => 'Nghiên Cứu Xã Hội', 'description' => 'Các phương pháp nghiên cứu xã hội', 'major_id' => 4],
            ['code' => 'SUBJ012', 'name' => 'Xã Hội và Văn Hóa', 'description' => 'Mối liên hệ giữa xã hội và văn hóa', 'major_id' => 4],

            // Các môn học cho chuyên ngành Hóa Học Ứng Dụng
            ['code' => 'SUBJ013', 'name' => 'Hóa Học Cơ Bản', 'description' => 'Các khái niệm cơ bản về hóa học', 'major_id' => 5],
            ['code' => 'SUBJ014', 'name' => 'Hóa Học Ứng Dụng', 'description' => 'Ứng dụng của hóa học trong đời sống', 'major_id' => 5],
            ['code' => 'SUBJ015', 'name' => 'Hóa Sinh', 'description' => 'Hóa học trong sinh học', 'major_id' => 5],

            // Các môn học cho chuyên ngành Sinh Học Ứng Dụng
            ['code' => 'SUBJ016', 'name' => 'Nhập Môn Sinh Học', 'description' => 'Giới thiệu về sinh học', 'major_id' => 6],
            ['code' => 'SUBJ017', 'name' => 'Sinh Học Tế Bào', 'description' => 'Cấu trúc và chức năng của tế bào', 'major_id' => 6],
            ['code' => 'SUBJ018', 'name' => 'Sinh Học Phân Tử', 'description' => 'Các phân tử trong sinh học', 'major_id' => 6],

            // Các môn học cho chuyên ngành Vật Lý Ứng Dụng
            ['code' => 'SUBJ019', 'name' => 'Vật Lý Cơ Bản', 'description' => 'Các khái niệm cơ bản về vật lý', 'major_id' => 7],
            ['code' => 'SUBJ020', 'name' => 'Vật Lý Ứng Dụng', 'description' => 'Ứng dụng của vật lý trong công nghệ', 'major_id' => 7],
            ['code' => 'SUBJ021', 'name' => 'Vật Lý Kỹ Thuật', 'description' => 'Vật lý trong kỹ thuật', 'major_id' => 7],

            // Các môn học cho chuyên ngành Toán Học Tài Chính
            ['code' => 'SUBJ022', 'name' => 'Toán Cơ Bản', 'description' => 'Các khái niệm cơ bản về toán học', 'major_id' => 8],
            ['code' => 'SUBJ023', 'name' => 'Toán Tài Chính', 'description' => 'Ứng dụng của toán học trong tài chính', 'major_id' => 8],
            ['code' => 'SUBJ024', 'name' => 'Thống Kê', 'description' => 'Các phương pháp thống kê', 'major_id' => 8],

            // Các môn học cho chuyên ngành Cơ Điện Tử
            ['code' => 'SUBJ025', 'name' => 'Cơ Học', 'description' => 'Cơ sở của cơ học', 'major_id' => 9],
            ['code' => 'SUBJ026', 'name' => 'Điện Tử', 'description' => 'Cơ sở của điện tử', 'major_id' => 9],
            ['code' => 'SUBJ027', 'name' => 'Cơ Điện Tử', 'description' => 'Kết hợp giữa cơ học và điện tử', 'major_id' => 9],

            // Các môn học cho chuyên ngành Quản Trị Kinh Doanh Quốc Tế
            ['code' => 'SUBJ028', 'name' => 'Quản Trị Doanh Nghiệp', 'description' => 'Quản lý và điều hành doanh nghiệp', 'major_id' => 10],
            ['code' => 'SUBJ029', 'name' => 'Kinh Doanh Quốc Tế', 'description' => 'Kinh doanh trên thị trường quốc tế', 'major_id' => 10],
            ['code' => 'SUBJ030', 'name' => 'Chiến Lược Kinh Doanh', 'description' => 'Các chiến lược kinh doanh hiệu quả', 'major_id' => 10],
        ]);
    }
}

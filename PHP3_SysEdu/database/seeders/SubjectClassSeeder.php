<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectClassSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('subject_classes')->insert([
            [
                'id' => 1,
                'name' => 'Lớp 1 CNTT',
                'quantity' => 30,
                'employee_id' => 1,
                'subject_id' => 1,
                'semester_id' => 1,
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
            [
                'id' => 2,
                'name' => 'Lớp 2 CNTT',
                'quantity' => 25,
                'employee_id' => 2, // ID của giáo viên từ bảng employees
                'subject_id' => 2, // ID của môn học từ bảng subjects
                'semester_id' => 2, // ID của học kỳ từ bảng semesters
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
            [
                'id' => 3,
                'name' => 'Lớp 1 Kinh Tế',
                'quantity' => 28,
                'employee_id' => 3, // ID của giáo viên từ bảng employees
                'subject_id' => 3, // ID của môn học từ bảng subjects
                'semester_id' => 3, // ID của học kỳ từ bảng semesters
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
            [
                'id' => 4,
                'name' => 'Lớp 2 Kinh Tế',
                'quantity' => 22,
                'employee_id' => 1, // ID của giáo viên từ bảng employees
                'subject_id' => 4, // ID của môn học từ bảng subjects
                'semester_id' => 4, // ID của học kỳ từ bảng semesters
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
            [
                'id' => 5,
                'name' => 'Lớp 1 Y Học',
                'quantity' => 20,
                'employee_id' => 2, // ID của giáo viên từ bảng employees
                'subject_id' => 5, // ID của môn học từ bảng subjects
                'semester_id' => 5, // ID của học kỳ từ bảng semesters
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
            [
                'id' => 6,
                'name' => 'Lớp 2 Y Học',
                'quantity' => 26,
                'employee_id' => 3, // ID của giáo viên từ bảng employees
                'subject_id' => 6, // ID của môn học từ bảng subjects
                'semester_id' => 6, // ID của học kỳ từ bảng semesters
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
            [
                'id' => 7,
                'name' => 'Lớp 1 Xã Hội',
                'quantity' => 30,
                'employee_id' => 1, // ID của giáo viên từ bảng employees
                'subject_id' => 7, // ID của môn học từ bảng subjects
                'semester_id' => 7, // ID của học kỳ từ bảng semesters
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
            [
                'id' => 8,
                'name' => 'Lớp 2 Xã Hội',
                'quantity' => 24,
                'employee_id' => 2, // ID của giáo viên từ bảng employees
                'subject_id' => 8, // ID của môn học từ bảng subjects
                'semester_id' => 8, // ID của học kỳ từ bảng semesters
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
            [
                'id' => 9,
                'name' => 'Lớp 1 Hóa Học',
                'quantity' => 28,
                'employee_id' => 3, // ID của giáo viên từ bảng employees
                'subject_id' => 9, // ID của môn học từ bảng subjects
                'semester_id' => 9, // ID của học kỳ từ bảng semesters
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
            [
                'id' => 10,
                'name' => 'Lớp 2 Hóa Học',
                'quantity' => 22,
                'employee_id' => 1, // ID của giáo viên từ bảng employees
                'subject_id' => 10, // ID của môn học từ bảng subjects
                'semester_id' => 10, // ID của học kỳ từ bảng semesters
                'start_date' => '2024-01-01',
                'end_date' => '2024-06-30',
                'registration_deadline' => '2023-12-15',
            ],
        ]);
    }
}

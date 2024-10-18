<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subjects')->insert([
            [
                'name' => 'Giáo dục chính trị',
                'code' => 'GDCT2024',
                'credit' => 5,
                'description' => 'Môn học',
                'major_id' => null,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Pháp luật',
                'code' => 'PL2024',
                'credit' => 2,
                'description' => 'Môn học',
                'major_id' => null,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Giáo dục thể chất',
                'code' => 'GDTC2024',
                'credit' => 2,
                'description' => 'Môn học',
                'major_id' => null,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],  
            [
                'name' => 'Giáo dục quốc phòng và An ninh',
                'code' => 'QPAN2024',
                'credit' => 2,
                'description' => 'Môn học',
                'major_id' => null,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ], 
            [
                'name' => 'Tin học',
                'code' => 'TH2024',
                'credit' => 2,
                'description' => 'Môn học',
                'major_id' => null,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ], 
            [
                'name' => 'Tiếng Anh 1',
                'code' => 'TAi2024',
                'credit' => 4,
                'description' => 'Môn học',
                'major_id' => null,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tiếng Anh 2',
                'code' => 'TAii2024',
                'credit' => 4,
                'description' => 'Môn học',
                'major_id' => null,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kỹ năng thiết yếu',
                'code' => 'KNTY2024',
                'credit' => 1,
                'description' => 'Môn học',
                'major_id' => null,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // chuyên ngành 1

            [
                'name' => 'Quản trị cơ sở dữ liệu MS SQL Server',
                'code' => 'MSSQL2024',
                'credit' => 3,
                'description' => 'Môn học',
                'major_id' => 1,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Thiết kế web',
                'code' => 'WEB2024',
                'credit' => 3,
                'description' => 'Môn học',
                'major_id' => 1,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Lập trình Java',
                'code' => 'JAVA2024',
                'credit' => 3,
                'description' => 'Môn học',
                'major_id' => 1,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            // chuyên ngành 2
            [
                'name' => 'Kỹ thuật lập trình',
                'code' => 'KTLT2024',
                'credit' => 2,
                'description' => 'Môn học',
                'major_id' => 2,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Đồ họa ứng dụng',
                'code' => 'DHUD2024',
                'credit' => 3,
                'description' => 'Môn học',
                'major_id' => 2,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Cơ sở dữ liệu',
                'code' => 'CSDL2024',
                'credit' => 2,
                'description' => 'Môn học',
                'major_id' => 2,
                'prerequisite_subject_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
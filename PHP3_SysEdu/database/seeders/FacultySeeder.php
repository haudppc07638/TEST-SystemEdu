<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FacultySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faculties = [
            [
                'id' => 1,
                'name' => 'Khoa Công Nghệ Thông Tin',
                'code' => 'CNTT001',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Công nghệ thông tin là lĩnh vực nghiên cứu và ứng dụng các công nghệ máy tính để xử lý thông tin.'
            ],
            [
                'id' => 2,
                'name' => 'Khoa Kinh Tế',
                'code' => 'KT002',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Kinh tế học nghiên cứu về cách thức phân phối tài nguyên để đạt được sự phát triển và thịnh vượng.'
            ],
            [
                'id' => 3,
                'name' => 'Khoa Y',
                'code' => 'Y003',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Khoa Y chuyên về đào tạo và nghiên cứu các lĩnh vực liên quan đến sức khỏe con người và y học.'
            ],
            [
                'id' => 4,
                'name' => 'Khoa Xã Hội',
                'code' => 'XH004',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Khoa Xã Hội nghiên cứu các vấn đề xã hội, văn hóa và các quan hệ giữa con người với nhau.'
            ],
            [
                'id' => 5,
                'name' => 'Khoa Hóa Học',
                'code' => 'HH005',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Khoa Hóa Học nghiên cứu về các chất hóa học, tính chất và phản ứng của chúng.'
            ],
            [
                'id' => 6,
                'name' => 'Khoa Sinh Học',
                'code' => 'SH006',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Khoa Sinh Học nghiên cứu về sự sống và các sinh vật sống, cũng như các tương tác của chúng với môi trường.'
            ],
            [
                'id' => 7,
                'name' => 'Khoa Vật Lý',
                'code' => 'VL007',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Khoa Vật Lý nghiên cứu về các hiện tượng vật lý và các định luật của tự nhiên.'
            ],
            [
                'id' => 8,
                'name' => 'Khoa Toán Học',
                'code' => 'TH008',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Khoa Toán Học chuyên nghiên cứu các lý thuyết và ứng dụng của toán học trong thực tiễn.'
            ],
            [
                'id' => 9,
                'name' => 'Khoa Cơ Điện Tử',
                'code' => 'CĐT009',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Khoa Cơ Điện Tử kết hợp giữa cơ học và điện tử để phát triển các hệ thống điều khiển và tự động hóa.'
            ],
            [
                'id' => 10,
                'name' => 'Khoa Quản Trị Kinh Doanh',
                'code' => 'QTKD010',
                'dean' => '',
                'assistant_dean' => '',
                'description' => 'Khoa Quản Trị Kinh Doanh đào tạo về các kỹ năng quản lý và điều hành doanh nghiệp.'
            ],
        ];

        DB::table('faculties')->insert($faculties);

    }
}

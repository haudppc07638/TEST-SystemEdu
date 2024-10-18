<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    public function run(): void
    {
        $employees = [
            [
                'full_name' => 'Nguyễn Văn A',
                'date_of_birth' => '1985-05-12',
                'gender' => 1,
                'nation' => 'Kinh',
                'email' => 'loctvpc06110@fpt.edu.vn',
                'code' => 'EMP001',
                'phone' => '0912345678',
                'image' => null,
                'position' => 'admin',
                'educational_level' => 'Thạc sĩ',
                'identity_card' => '012345678',
                'card_issuance_date' => '2015-05-20',
                'card_location' => 'Hà Nội',
                'provice_city' => 'Hà Nội',
                'district' => 'Cầu Giấy',
                'commune_level' => 'Dịch Vọng',
                'house_number' => '123',
                'graduate' => 'Đại học Bách Khoa Hà Nội',
                'year_graduation' => 2010,
                'major_id' => 1,
                'department_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        // Thêm các nhân viên khác vào mảng $employees
        $moreEmployees = collect(range(2, 9))->map(function ($i) {
            return [
                'full_name' => "Thái $i",
                'date_of_birth' => now()->subYears(25 + $i)->toDateString(),
                'gender' => $i % 2, // 0: Nam, 1: Nữ
                'nation' => 'Kinh',
                'email' => "nhanvien$i@fpt.edu.vn",
                'code' => "EMP00$i",
                'phone' => '090' . random_int(1000000, 9999999),
                'image' => null,
                'position' => 'teacher',
                'educational_level' => 'Cử nhân',
                'identity_card' => Str::random(9),
                'card_issuance_date' => now()->subYears(5 + $i)->toDateString(),
                'card_location' => 'Hà Nội',
                'provice_city' => 'Hà Nội',
                'district' => 'Quận ' . $i,
                'commune_level' => 'Phường ' . $i,
                'house_number' => (string) $i,
                'graduate' => 'Đại học Kinh Tế Quốc Dân',
                'year_graduation' => now()->year - 5 - $i,
                'major_id' => random_int(1, 4),
                'department_id' => random_int(1, 5),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        // Gộp các mảng lại và chèn vào cơ sở dữ liệu
        DB::table('employees')->insert(array_merge($employees, $moreEmployees));
    }
}

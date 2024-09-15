<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('employees')->insert([
            ['id' => 1, 'fullname' => 'Thái Văn Lộc', 'email' => 'loctvpc06110@fpt.edu.vn', 'password' => Hash::make('abc1234'), 'phone' => '0828581112', 'image' => 'abc123.jpg', 'position' => 'Giáo viên', 'faculty_id' => 1, 'department_id' => 1],
            ['id' => 2, 'fullname' => 'Danh Phúc Hậu', 'email' => 'haudppc07638@fpt.fpt.edu.vn', 'password' => Hash::make('password123'), 'phone' => '0912345678', 'image' => 'userdefaul.jpg', 'position' => 'Giáo viên', 'faculty_id' => 2, 'department_id' => 2],
            ['id' => 3, 'fullname' => 'Trần Thị B', 'email' => 'tranb@example.com', 'password' => Hash::make('mypassword'), 'phone' => '0923456789', 'image' => 'tranb.jpg', 'position' => 'Giáo viên', 'faculty_id' => 3, 'department_id' => 3]
        ]);
    }
}

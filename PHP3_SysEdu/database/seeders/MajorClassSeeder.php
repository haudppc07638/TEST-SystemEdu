<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MajorClassSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('major_classes')->insert([
            // Chuyên ngành 1: Phát triển phần mềm
            [
                'training_system' => 'Chính quy',
                'name' => 'Ứng dụng phần mềm - SW001',
                'quantity' => 30,
                'status' => 0,
                'major_id' => 1,
                'employee_id' => 2, 
                'start_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'training_system' => 'Chính quy',
                'name' => 'Ứng dụng phần mềm - SW002',
                'quantity' => 30,
                'status' => 0,
                'major_id' => 1,
                'employee_id' => 3,
                'start_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],

            
            [
                'training_system' => 'Chính quy',
                'name' => 'Chế biến thực phẩm - TP001',
                'quantity' => 30,
                'status' => 0,
                'major_id' => 3,
                'employee_id' => 4,
                'start_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'training_system' => 'Chính quy',
                'name' => 'Chế biến thực phẩm - TP002',
                'quantity' => 30,
                'status' => 0,
                'major_id' => 3,
                'employee_id' => 5,
                'start_date' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        
    }
}

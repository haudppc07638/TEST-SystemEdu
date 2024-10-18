<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubjectLecturersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("subject_lecturers")->insert([
            [
                'subject_id' => 1,
                'employee_id' => 2,
            ],
            [
                'subject_id' => 2,
                'employee_id' => 2,
            ],
            [
                'subject_id' => 3,
                'employee_id' => 2,
            ],
            [
                'subject_id' => 4,
                'employee_id' => 2,
            ],
            [
                'subject_id' => 10,
                'employee_id' => 2,
            ],
        ]);
    }
}

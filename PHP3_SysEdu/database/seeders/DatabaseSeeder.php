<?php

namespace Database\Seeders;

use Database\Seeders\StudentSeeder as SeedersStudentSeeder;
use Illuminate\Database\Seeder;
use StudentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call([
            // DepartmentSeeder::class,
            // FacultySeeder::class,
            // MajorSeeder::class,
            // EmployeeSeeder::class,
            // SubjectSeeder::class,
            // SemesterSeeder::class,
            ClassroomSeeder::class,
            TimeSlotSeeder::class,
            MajorClassSeeder::class,
            SeedersStudentSeeder::class,

            // SubjectLecturersSeeder::class,
        ]);
    }
}

<?php

namespace Database\Seeders;

use App\Models\Major;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call([
            // EmployeeSeeder::class,
            // FacultySeeder::class,
            // MajorSeeder::class,
            // StuClassSeeder::class,
            // StudentSeeder::class,
            // StudentSubjectClassSeeder::class,
            // DepartmentSeeder::class,
            // ScheduleSeeder::class,
            // SubjectSeeder::class,
            // SubjectClassSeeder::class,
            // TimeSlotSeeder::class,
            SemesterSeeder::class,
            // DayCombinationSeeder::class,
            // NotificationSeeder::class,
            // ClassroomSeeder::class,
            // SemesterSeeder::class,
        ]);
      
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        foreach (range(1, 50) as $index) {
            DB::table('enrollments')->insert([
                'full_name' => $faker->name,
                'date_of_birth' => $faker->date('Y-m-d', '2005-12-31'),
                'gender' => $faker->numberBetween(0, 1), // 0: Nam, 1: Nữ
                'nation' => $faker->country,
                'identity_card' => $faker->unique()->regexify('[0-9]{9}'),
                'card_issuance_date' => $faker->date('Y-m-d', '2023-01-01'),
                'card_location' => $faker->city,
                'province_city' => $faker->city,
                'district' => $faker->city,
                'commune_level' => $faker->streetName,
                'house_number' => $faker->buildingNumber,
                'phone' => $faker->unique()->regexify('[0-9]{10}'),
                'email' => $faker->unique()->email,
                'sponsor_name' => $faker->name,
                'sponsor_phone' => $faker->unique()->regexify('[0-9]{10}'),
                'first_major_id' => $faker->numberBetween(1, 5), // Giả sử có 5 major
                'application_method_1' => $faker->randomElement(['grade_score', 'exam_score']),
                'second_major_id' => $faker->optional()->numberBetween(1, 5),
                'application_method_2' => $faker->optional()->randomElement(['grade_score', 'exam_score']),
                'year_graduation' => $faker->year('2023'),
                'provice_city_graduate' => $faker->city,
                'district_graduate' => $faker->city,
                'commune_level_graduate' => $faker->streetName,
                'recipient' => $faker->randomElement(['student', 'parents']),
                'address' => $faker->randomElement(['residence_address', 'at_school']),
                'front_id_card' => $faker->imageUrl(640, 480, 'people', true, 'Front ID Card'),
                'back_id_card' => $faker->imageUrl(640, 480, 'people', true, 'Back ID Card'),
                'graduation_certificate' => $faker->imageUrl(640, 480, 'education', true, 'Graduation Certificate'),
                'created_at' => now(),
            ]);
        }
    }
}

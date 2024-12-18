<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enrollments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->date('date_of_birth');
            $table->tinyInteger('gender');
            $table->string('nation', 100);
            $table->string('identity_card', 15);
            $table->date('card_issuance_date');
            $table->string('card_location');
            $table->string('province_city', 150);
            $table->string('district', 150);
            $table->string('commune_level', 150);
            $table->string('house_number', 10);
            $table->string('phone', 15);
            $table->string('email', 150)->unique();
            $table->string('sponsor_name', 150);
            $table->string('sponsor_phone', 15);
            $table->foreignId('first_major_id')->constrained('majors'); // Nguyện vọng 1
            $table->enum('application_method_1', ['grade_score', 'exam_score']);
            $table->foreignId('second_major_id')->nullable()->constrained('majors'); // Nguyện vọng 2
            $table->enum('application_method_2', ['grade_score', 'exam_score'])->nullable();
            $table->year('year_graduation');
            $table->string('provice_city_graduate', 150);
            $table->string('district_graduate', 150);
            $table->string('commune_level_graduate', 150);
            $table->enum('recipient', ['student', 'parents']);
            $table->enum('address', ['residence_address', 'at_school']);
            $table->string('front_id_card'); // Ảnh căn cước mặt trước
            $table->string('back_id_card');  // Ảnh căn cước mặt sau
            $table->string('graduation_certificate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enrollments');
    }
};

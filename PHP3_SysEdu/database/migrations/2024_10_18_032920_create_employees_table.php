<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name' , 150);
            $table->date('date_of_birth');
            $table->tinyInteger('gender');
            $table->string('nation' , 100);
            $table->string('email' , 150)->unique();
            $table->string('code' , 15)->unique();
            $table->string('phone' , 15);
            $table->string('image')->nullable();
            $table->enum('position', ['admin', 'teacher']);
            $table->string('educational_level', 150);

            $table->string('identity_card', 15);
            $table->date('card_issuance_date');
            $table->string('card_location');

            $table->string('provice_city', 150);
            $table->string('district', 150);
            $table->string('commune_level', 150);
            $table->string('house_number', 10);

            $table->string('graduate', 150);
            $table->year('year_graduation');

            $table->foreignId('major_id')->constrained('majors');
            $table->foreignId('department_id')->constrained('departments');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};

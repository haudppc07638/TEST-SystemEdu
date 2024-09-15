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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 100);
            $table->string('code', 10);
            $table->string('email', 100)->unique();
            $table->string('password', 60);
            $table->string('phone', 15);
            $table->string('image')->nullable();

            $table->foreignId('major_id')->nullable()->constrained('majors')->onDelete('set null');
            $table->foreignId('class_id')->nullable()->constrained('classes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

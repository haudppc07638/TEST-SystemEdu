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
        Schema::table('feedback_questions', function (Blueprint $table) {
            // Thay đổi cột student_id để cho phép NULL
            $table->foreignId('student_id')->nullable()->change();

            // Thay đổi cột employee_id để cho phép NULL
            $table->foreignId('employee_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_questions', function (Blueprint $table) {
            // Hoàn lại các cột ban đầu, không cho phép NULL
            $table->foreignId('student_id')->change();
            $table->foreignId('employee_id')->change();
        });
    }
};

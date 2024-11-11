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
        if (Schema::hasTable('schedules')) {
            Schema::create('schedule_histories', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->foreignId('schedule_id')->constrained('schedules')->onDelete('cascade');
                $table->date('date');
                $table->foreignId('subject_class_id')->constrained('subject_classes');
                $table->foreignId('classroom_id')->constrained('classrooms');
                $table->foreignId('time_slot_id')->constrained('time_slots');
                $table->foreignId('substitute_employee_id')->nullable()->constrained('employees');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_histories');
    }
};

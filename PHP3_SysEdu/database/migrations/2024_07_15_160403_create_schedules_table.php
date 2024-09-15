<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->date('schedule_day');
            $table->foreignId('time_slot_id')->nullable()->constrained('time_slots')->onDelete('set null');
            $table->foreignId('classroom_id')->nullable()->constrained('classrooms')->onDelete('set null');
            $table->foreignId('subject_class_id')->nullable()->constrained('subject_classes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};

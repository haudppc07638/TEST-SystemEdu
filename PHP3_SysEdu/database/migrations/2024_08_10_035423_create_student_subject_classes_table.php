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
        schema::create('student_subject_classes', function (Blueprint $table) {
            $table->id();
            
            $table->decimal('midterm_score', 4,2);
            $table->decimal('final_score', 4,2);
            $table->decimal('total_score', 4,2);
            $table->string('classification', 50);
            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('set null');
            $table->foreignId('subject_class_id')->nullable()->constrained('subject_classes')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_subject_classes');
    }
};

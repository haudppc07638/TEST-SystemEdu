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
        Schema::create('student_subject_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->decimal('total_score', 4, 2)->nullable();
            $table->string('classification')->nullable();
            $table->string('status')->default('fail');
            $table->foreignId('student_id')->constrained('students');
            $table->foreignId('subject_class_id')->constrained('subject_classes');
            $table->timestamps();
            $table->softDeletes();
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

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
        Schema::create('subject_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name', 100);
            $table->unsignedInteger('quantity');
            $table->date('start_date');
            $table->date('end_date');
            $table->date('registration_deadline');
            $table->boolean('status')->default(0);
            $table->decimal('price', 10, 2);

            $table->foreignId('employee_id')->constrained('employees');
            $table->foreignId('subject_id')->constrained('subjects');
            $table->foreignId('semester_id')->constrained('semesters');
            $table->foreignId('credit_id')->constrained('credits');
            $table->foreignId('major_class_id')->constrained('major_classes');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_classes');
    }
};

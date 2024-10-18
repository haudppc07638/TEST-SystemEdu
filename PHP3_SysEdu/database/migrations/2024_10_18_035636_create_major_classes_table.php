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
        Schema::create('major_classes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('training_system');
            $table->string('name', 100);
            $table->unsignedInteger('quantity'); // số lượng tôi đa của sinh viên trong 1 lớp
            $table->boolean('status')->default(0);
            $table->foreignId('major_id')->constrained('majors');
            $table->foreignId('employee_id')->constrained('employees');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('major_classes');
    }
};

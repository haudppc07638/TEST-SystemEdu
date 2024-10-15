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
        Schema::create('total_tuitions', function (Blueprint $table) {
            $table->id();
            $table->float('total_amount');
            $table->integer('total_credit');
            $table->enum('tuition_status',['unpaid', 'paid', 'late'])->default('unpaid');

            $table->foreignId('student_id')->nullable()->constrained('students')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('total_tuitions');
    }
};

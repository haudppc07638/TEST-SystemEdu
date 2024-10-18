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
            $table->decimal('total_amount', 10, 2);
            $table->unsignedSmallInteger('total_credit');
            $table->enum('payment_status', ['paid', 'unpaid', 'late']);
            $table->date('payment_date')->nullable();
            $table->foreignId('tuition_id')->constrained('tuitions');
            $table->foreignId('student_id')->constrained('students');
            $table->timestamps();
            $table->softDeletes();
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

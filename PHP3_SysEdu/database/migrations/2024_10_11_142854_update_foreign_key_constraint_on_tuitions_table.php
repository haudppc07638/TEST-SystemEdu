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
        Schema::table('tuitions', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['student_subject_class_id']); // Make sure to specify the correct column

            // Add the new foreign key constraint with 'cascade' delete
            $table->foreign('student_subject_class_id')->references('id')->on('student_subject_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tuitions', function (Blueprint $table) {
            // Rollback the foreign key change
            $table->dropForeign(['student_subject_class_id']);

            // Add the previous foreign key constraint back with 'set null'
            $table->foreign('student_subject_class_id')->references('id')->on('student_subject_classes')->onDelete('set null');
        });
    }
};

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
        Schema::table('subject_score_types', function (Blueprint $table) {
            $table->dropForeign(['subject_id']);
            $table->dropForeign(['score_type_id']);
        });

        Schema::table('subject_score_types', function (Blueprint $table) {
            $table->foreign('subject_id')->references('id')->on('subjects')->onDelete('cascade');
            $table->foreign('score_type_id')->references('id')->on('score_types')->onDelete('cascade');
        });
    }
};

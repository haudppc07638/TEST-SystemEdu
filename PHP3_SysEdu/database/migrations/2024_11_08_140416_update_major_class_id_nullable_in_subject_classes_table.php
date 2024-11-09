<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('subject_classes', function (Blueprint $table) {
            $table->foreignId('major_class_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('subject_classes', function (Blueprint $table) {
            $table->foreignId('major_class_id')->nullable(false)->change();
        });
    }
};

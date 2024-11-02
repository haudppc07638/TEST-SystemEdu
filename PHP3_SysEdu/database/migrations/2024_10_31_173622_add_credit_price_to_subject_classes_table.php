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
        Schema::table('subject_classes', function (Blueprint $table) {
            $table->decimal('credit_price', 10, 2)->nullable()->after('credit_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('subject_classes', function (Blueprint $table) {
            $table->dropColumn('credit_price');
        });
    }
};

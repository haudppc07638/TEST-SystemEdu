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
        Schema::table('feedback_results', function (Blueprint $table) {
            // Thay đổi cột results thành nullable
            $table->unsignedSmallInteger('results')->nullable()->change();

            // Thay đổi cột expertise thành nullable
            $table->string('expertise')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('feedback_results', function (Blueprint $table) {
            // Hoàn lại các cột về trạng thái không nullable
            $table->unsignedSmallInteger('results')->nullable(false)->change();
            $table->string('expertise')->nullable(false)->change();
        });
    }
};

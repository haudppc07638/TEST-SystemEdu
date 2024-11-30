<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveTrainingSystemFromStuClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('major_classes', function (Blueprint $table) {
            $table->dropColumn('training_system'); // Xóa cột training_system
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('major_classes', function (Blueprint $table) {
            $table->string('training_system')->nullable(); // Thêm lại cột nếu cần
        });
    }
}
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up()
    {
        Schema::table('subject_histories', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->string('type')->nullable()->after('student_subject_class_id'); 
        });
    }

    public function down()
    {
        Schema::table('subject_histories', function (Blueprint $table) {
            $table->dropColumn('type'); 
            $table->string('status')->nullable(); 
        });
    }
};

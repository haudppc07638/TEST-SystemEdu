<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending')->after('date_sent');
        });
    }

    public function down()
    {
        Schema::table('notification', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};

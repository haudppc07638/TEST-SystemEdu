<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveVatAndTotalPriceFromCreditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->dropColumn(['vat', 'total_price']); // Xóa cột vat và total_price
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('credits', function (Blueprint $table) {
            $table->decimal('vat', 8, 2)->nullable(); // Thêm lại cột vat nếu cần
            $table->decimal('total_price', 10, 2)->nullable(); // Thêm lại cột total_price nếu cần
        });
    }
}
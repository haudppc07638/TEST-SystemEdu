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
        Schema::create('subjects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name' , 100);
            $table->string('code', 15)->unique();
            $table->unsignedSmallInteger( 'credit');
            $table->text('description')->nullable();
            $table->foreignId('major_id')->nullable()->constrained('majors');
            $table->foreignId('prerequisite_subject_id')->nullable()->constrained('subjects'); 
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};

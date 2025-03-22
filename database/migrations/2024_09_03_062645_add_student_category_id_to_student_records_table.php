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
        Schema::table('student_records', function (Blueprint $table) {
            $table->integer('student_category_id')->nullable()->unsigned();
            $table->foreign('student_category_id')->references('id')->on('sm_student_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_records', function (Blueprint $table) {
            //
        });
    }
};

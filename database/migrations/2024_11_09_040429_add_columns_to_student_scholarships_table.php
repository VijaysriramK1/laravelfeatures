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
        Schema::table('student_scholarships', function (Blueprint $table) {
            $table->unsignedBigInteger('class_id')->after('id');
            $table->unsignedBigInteger('section_id')->after('class_id');
            $table->unsignedBigInteger('group_id')->after('section_id');
            $table->unsignedBigInteger('academic_id')->after('awarded_date');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_scholarships', function (Blueprint $table) {
            //
        });
    }
};
